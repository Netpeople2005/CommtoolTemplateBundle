<?php

namespace Optime\Commtool\TemplateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Optime\Commtool\TemplateBundle\Entity\Image;
use Optime\Commtool\TemplateBundle\Form\ImageType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Image controller.
 *
 */
class ImageController extends Controller
{

    /**
     * Lists all Image entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CommtoolTemplateBundle:Image')->findAll();

        return $this->render('CommtoolTemplateBundle:Image:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Image entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Image();
        $form = $this->createForm(new ImageType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gallery_show', array('id' => $entity->getId())));
        }

        return $this->render('CommtoolTemplateBundle:Image:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Image entity.
     *
     */
    public function newAction()
    {
        $entity = new Image();
        $form = $this->createForm(new ImageType(), $entity);

        return $this->render('CommtoolTemplateBundle:Image:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Image entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommtoolTemplateBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CommtoolTemplateBundle:Image:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Image entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommtoolTemplateBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $editForm = $this->createForm(new ImageType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CommtoolTemplateBundle:Image:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Image entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommtoolTemplateBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ImageType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gallery_edit', array('id' => $id)));
        }

        return $this->render('CommtoolTemplateBundle:Image:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Image entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CommtoolTemplateBundle:Image')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Image entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gallery'));
    }

    /**
     * Creates a form to delete a Image entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    public function getGalleryAction($sectionId)
    {
        $gallery = $this->getDoctrine()
                ->getManager()
                ->createQuery("SELECT sg,i FROM CommtoolTemplateBundle:SectionGallery sg
                    JOIN sg.images i
                    JOIN sg.section s
                    WHERE s.id = :sectionId")
                ->setParameter('sectionId', $sectionId)
                ->getSingleResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
        
        return new JsonResponse($gallery['images']);
    }

}
