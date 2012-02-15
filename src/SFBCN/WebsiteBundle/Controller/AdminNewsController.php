<?php

namespace SFBCN\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SFBCN\WebsiteBundle\Entity\SFNew;
use SFBCN\WebsiteBundle\Form\SFNewType;

/**
 * SFNew controller.
 *
 * @Route("/admin/new")
 */
class AdminNewsController extends Controller
{
    /**
     * Lists all SFNew entities.
     *
     * @Route("/", name="new")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SFBCNWebsiteBundle:SFNew')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a SFNew entity.
     *
     * @Route("/{id}/show", name="new_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SFBCNWebsiteBundle:SFNew')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SFNew entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
     * Displays a form to create a new SFNew entity.
     *
     * @Route("/new", name="new_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SFNew();
        $form   = $this->createForm(new SFNewType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new SFNew entity.
     *
     * @Route("/create", name="new_create")
     * @Method("post")
     * @Template("SFBCNWebsiteBundle:SFNew:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new SFNew();
        $request = $this->getRequest();
        $form    = $this->createForm(new SFNewType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('new_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing SFNew entity.
     *
     * @Route("/{id}/edit", name="new_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SFBCNWebsiteBundle:SFNew')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SFNew entity.');
        }

        $editForm = $this->createForm(new SFNewType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing SFNew entity.
     *
     * @Route("/{id}/update", name="new_update")
     * @Method("post")
     * @Template("SFBCNWebsiteBundle:SFNew:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SFBCNWebsiteBundle:SFNew')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SFNew entity.');
        }

        $editForm   = $this->createForm(new SFNewType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('new_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SFNew entity.
     *
     * @Route("/{id}/delete", name="new_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SFBCNWebsiteBundle:SFNew')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SFNew entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('new'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
