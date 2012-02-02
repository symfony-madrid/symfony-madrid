<?php

namespace SFBCN\WebsiteBundle\Controller;

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
        $nextEvent = $em->getRepository('SFBCNWebsiteBundle:Event')->getNextEvent();

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

        $this->validateContactData($contactData);
        $mailTo = $this->container->getParameter('contactmail');

        $message =\Swift_Message::newInstance()
                    ->setSubject('Mensaje recibido desde la web Symfony-Barcelona')
                    ->setFrom(array($contactData['email'] => $contactData['nombre']))
                    ->setTo($mailTo)
                    ->setBody($contactData['mensaje']);

        $this->container->get('mailer')->send($message);

        return new Response(json_encode(array('message' => 'Mail enviado correctamente. En breve contactaremos contigo')));
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
            throw new HttpException(400, $errors[0]->getPropertyPath() . ':' . $this->container->get('translator')->trans($errors[0]->getMessage(), array(), 'validators'));
        }
    }

    /**
     * @var array $founders Symfony-Barcelona group founders
     */
    private $founders = array(
            array(
                'name' => 'Ricard Clau',
                'description' => 'PHP Believer, namespaces lover, #rigor is all around',
                'email' => 'ricard.clau[at]gmail[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/2d5aaa5bfc55afb812af6693826e382b?size=140',
                'github' => 'ricardclau',
                'twitter' => 'ricardclau',
                'linkedin' => 'http://es.linkedin.com/pub/ricard-clau/1/7a0/744',
            ),
            array(
                'name' => 'Marcos Quesada',
                'description' => "Well, the way they make shows is, they make one show.",
                'email' => 'marcos.quesadas[at]gmail[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/2be6fb2856a0b294c3b723bfaced58b1?s=140',
                'github' => 'marcosquesada',
                'twitter' => 'marcos_quesada',
                'linkedin' => 'http://es.linkedin.com/in/marcosquesada',
            ),
            array(
                'name' => 'Berny Cantos',
                'description' => "Well, the way they make shows is, they make one show.",
                'email' => 'xphere81[at]gmail[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/91e6dcf71c768d042917912229786b85?s=140',
                'github' => 'xphere',
                'twitter' => 'xphere',
                'linkedin' => 'http://es.linkedin.com/pub/berny-cantos/37/403/b79',
            ),
            array(
                'name' => 'Adán Lobato',
                'description' => "Well, the way they make shows is, they make one show.",
                'email' => 'adan.lobato[at]gmail[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/4295f5a4b169152d287fc4009d1afb19?size=140',
                'github' => 'adanlobato',
                'twitter' => 'adanlobato',
                'linkedin' => 'http://es.linkedin[dot]com/in/adanlobato',
            ),
            array(
                'name' => 'Alberto Ramírez',
                'description' => "Well, the way they make shows is, they make one show.",
                'email' => 'alberto[at]aramirez.es',
                'foto' => 'http://1.gravatar.com/avatar/93b1e299aefc6100c98d26b93ee987d2?size=140',
                'github' => 'aramirez-es',
                'twitter' => 'aramirez_',
                'linkedin' => 'http://es.linkedin.com/pub/alberto-ramirez-fernandez/17/131/289',
            ),
            array(
                'name' => 'Oriol Jiménez',
                'description' => "Well, the way they make shows is, they make one show.",
                'email' => 'oriol[at]phpbsd.net',
                'foto' => 'http://1.gravatar.com/avatar/ffe9ce4a6a97b5749e4096a96ceaf495?size=140',
                // 'github' => '',
                'twitter' => 'orioljimenez',
                'linkedin' => 'http://es.linkedin.com/in/orioljimenez',
            ),
            array(
                'name' => 'Carlos Iglesias',
                'description' => "Well, the way they make shows is, they make one show.",
                'email' => 'carlos[at]runroom[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/7a836ecca82bed330f8faa13a8ec9bb2?size=140',
                // 'github' => '',
                'twitter' => 'carlosthesailor',
                'linkedin' => 'http://es.linkedin.com/in/carlosiglesiaspichel',
            ),
            array(
                'name' => 'Christian Soronellas',
                'description' => "Well, the way they make shows is, they make one show.",
                'email' => 'theunic[at]gmail[dot]com',
                'foto' => 'http://1.gravatar.com/avatar/dfdd9fcf3d8e8df633d142fcb986c5fa?size=140',
                'github' => 'theunic',
                'twitter' => 'theunic',
                'linkedin' => 'http://es.linkedin.com/in/christiansoronellas',
            )
        );
}
