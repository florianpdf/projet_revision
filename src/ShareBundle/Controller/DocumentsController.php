<?php

namespace ShareBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ShareBundle\Entity\Documents;
use ShareBundle\Form\DocumentsType;

/**
 * Documents controller.
 *
 */
class DocumentsController extends Controller
{
    /**
     * Lists all Documents entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $documents = $em->getRepository('ShareBundle:Documents')->findAll();

        return $this->render('@Share/documents/index.html.twig', array(
            'documents' => $documents,
        ));
    }

    /**
     * Creates a new Documents entity.
     *
     */
    public function newAction(Request $request)
    {
        $document = new Documents();
        $form = $this->createForm('ShareBundle\Form\DocumentsType', $document);
        $form->handleRequest($request);

        $usr = $this->get('security.token_storage')->getToken()->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $document->setUser($usr);
            $document->setDatePublication(new \DateTime());
            $document->setDateModification(null);

            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute('documents_show', array('id' => $document->getId()));
        }

        return $this->render('@Share/documents/new.html.twig', array(
            'document' => $document,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a Documents entity.
     *
     */
    public function showAction(Documents $document)
    {
        $deleteForm = $this->createDeleteForm($document);

        return $this->render('@Share/documents/show.html.twig', array(
            'document' => $document,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Documents entity.
     *
     */
    public function editAction(Request $request, Documents $document)
    {
        $deleteForm = $this->createDeleteForm($document);
        $editForm = $this->createForm('ShareBundle\Form\DocumentsType', $document);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();

            return $this->redirectToRoute('documents_edit', array('id' => $document->getId()));
        }

        return $this->render('@Share/documents/edit.html.twig', array(
            'document' => $document,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Documents entity.
     *
     */
    public function deleteAction(Request $request, Documents $document)
    {
        $form = $this->createDeleteForm($document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);
            $em->flush();
        }

        return $this->redirectToRoute('documents_index');
    }

    /**
     * Creates a form to delete a Documents entity.
     *
     * @param Documents $document The Documents entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Documents $document)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('documents_delete', array('id' => $document->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
