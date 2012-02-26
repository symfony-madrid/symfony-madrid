<?php

namespace SFM\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DefaultController extends Controller
{
    /**
     * Renders Home page
     *
     * @return array
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $nextEvent = $em->getRepository('SFMWebsiteBundle:Event')->getNextEvent();

        return array(
            'current' => 'home',
            'nextEvent' => $nextEvent,
        );
    }

    /**
     * Renders About page
     *
     * @return array
     * @Route("/acerca-de", name="about")
     * @Template()
     */
    public function aboutAction()
    {
        /**
         * Better a random order than alphabetical :)
         */
        shuffle($this->founders);
        $sfConnect = $this->get('sensio_connect')->getGroupInfo();
        $totalBadges = 0;
        foreach ($sfConnect['cumulated_badges'] as $badge) $totalBadges += $badge['count'];

        return array(
            'current' => 'about',
            'founders' => $this->founders,
            'members' => $sfConnect['members'],
            'badges' => $sfConnect['cumulated_badges'],
            'totalBadges' => $totalBadges,
        );
    }

    /**
     * Renders Contact page
     *
     * @return array
     * @Route("/contacto", name="contact")
     * @Method("get")
     * @Template()
     */
    public function contactAction()
    {
        return array(
            'current' => 'contact',
        );
    }

    /**
     * Sends the email through AJAX
     *
     * @return array
     * @Route("/contacto", name="contact_post", defaults={"_format"="json"})
     * @Method("post")
     * @Template()
     */
    public function sendMailAction()
    {
        $contactData = array(
           'nombre' => $this->getRequest()->get('nombre'),
           'email' => $this->getRequest()->get('email'),
           'mensaje' => $this->getRequest()->get('mensaje'),
        );

        try {

            $this->validateContactData($contactData);

        } catch (HttpException $e) {
            
            /**
             * Due to HttpException only accept a text message and we need
             * a json array, we catching the HttpException to return a new
             * Response object with message in json format and status code.
             */
            return new Response($e->getMessage(), $e->getStatusCode());
        }

        $this->sendMailOnContactFormSuccess($contactData);

        return new Response(json_encode(
            array('message' => 'Mail enviado correctamente. En breve contactaremos contigo')
        ));
    }

    /**
     * Extract method to send the email with data receive from contact form.
     *
     * @param array $contactData Data given from contact form.
     */
    private function sendMailOnContactFormSuccess(Array $contactData)
    {
        $mailTo = $this->container->getParameter('contactmail');

        $message =\Swift_Message::newInstance()
                    ->setSubject('Mensaje recibido desde la web Symfony-Barcelona')
                    ->setFrom(array($contactData['email'] => $contactData['nombre']))
                    ->setTo($mailTo)
                    ->setBody($contactData['mensaje']);

        $this->container->get('mailer')->send($message);
    }

    /**
     * Validates contact data and throws exception if anything goes wrong
     *
     * @param array $contactData
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function validateContactData(array $contactData)
    {
        $collectionConstraint = new Collection(array(
            'nombre' => array(
                new NotBlank()
             ),
            'email' => array(
                new NotBlank(),
                new Email(),
            ),
            'mensaje' => array(
                new NotBlank()
            ),
        ));

        $errors = $this->container->get('validator')->validateValue($contactData, $collectionConstraint);
        if (count($errors) !== 0) {
            throw new HttpException(400, $this->parseErrors($errors));
        }
    }

    private function parseErrors($errors) {

        $translator = $this->container->get('translator');
        $parsedErrors = array();

        foreach($errors as $error) {

            $translatedError = $translator->trans($error->getMessage(), array(), 'validators');
            $parsedErrors[substr($error->getPropertyPath(), 1, -1)] = $translatedError;

        }

        return json_encode($parsedErrors);
    }

    /**
     * @var array $founders Symfony-Madrid group founders
     */
    private $founders = array(
            array(
                'name' => 'Óscar López',
                'description' => 'Web Developer en Blaffin.com',
                'email' => 'zepolracso[at]gmail[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/30b1c6544fe3993f4c4bc5d2c3cc1998?size=140',
                'github' => 'Osukaru',
                'twitter' => 'Osukaru80',
                'betabeers' => 'http://dir.betabeers.com/user/oscar-lopez-carazo-59/',
            ),
            array(
                'name' => 'Moisés Gallego',
                'description' => 'Programador, sysadmin, CEO, CTO, SEO, ABC ... XYZ en Picmnt.com',
                'email' => 'moisesgallego[at]gmail[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/0fbb80757bb88d09cb11a069d2f00282?s=140',
                'github' => 'mgallego',
                'twitter' => 'moisesgallego',
                'betabeers' => 'http://dir.betabeers.com/user/moises-gallego-138/',
            ),
            array(
                'name' => 'Daniel González',
                'description' => 'Developer & Team manager en RadMas',
                'email' => 'daniel.gonzalez[at]freelancemadrid[dot]es',
                'foto' => 'http://1.gravatar.com/avatar/e31141ecebae853059760217e1c7d8c3?s=140',
                'github' => 'desarrolla2',
                'twitter' => 'desarrolla2',
                //'betabeers' => '',
            ),
            array(
                'name' => 'Moisés Macia',
                'description' => 'Senior software developer en ideup!',
                'email' => 'mmacia[at]gmail[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/bda8302cf8bb9867e4732740d8a125f5?size=140',
                'github' => 'mmacia',
                'twitter' => 'moises_macia',
                'betabeers' => 'http://dir.betabeers.com/user/moises-macia-205/',
            ),
            array(
                'name' => 'Eduardo Gulias',
                'description' => 'Arquitecto de Software en ideup!',
                'email' => 'eduardomgulias[at]gmail[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/48640daa8e9f07f94c8ca44805cd98eb?size=140',
                'github' => 'egulias',
                'twitter' => 'egulias',
                'betabeers' => 'http://dir.betabeers.com/user/eduardo-gulias-davis-854/',
            ),
            array(
                'name' => 'Francisco Javier Aceituno',
                'description' => 'Software Engineer en ideup!',
                'email' => 'fco.javier.aceituno[at]gmail[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/7e99009a0d6c0c0d2da13e4f83b9bd5d?size=140',
                'github' => 'javiacei',
                'twitter' => 'javiacei',
                //'betabeers' => '',
            )
        );
}
