<?php

namespace Optime\Commtool\TemplateBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Optime\Commtool\TemplateBundle\Entity\Template;
use Optime\Commtool\TemplateBundle\Locator\FilesBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Optime\Commtool\TemplateBundle\Entity\TemplateSection;

class DefaultController extends Controller
{

    public function editAction($id)
    {
        $template = $this->getDoctrine()
                ->getManager()
                ->getRepository('CommtoolTemplateBundle:Template')
                ->find($id);

        return $this->render('CommtoolTemplateBundle:Default:edit.html.twig', array(
                    'template' => $template,
        ));
    }

    public function selectTemplateAction()
    {
        $bundles = array_keys($this->get('kernel')->getBundles());

        return $this->render('CommtoolTemplateBundle:Default:selectTemplate.html.twig', array(
                    'bundles' => $bundles,
        ));
    }

    public function getFilesFromViewAction($bundle)
    {
        $dir = $this->get('kernel')->locateResource("@$bundle");

        $files = FilesBundle::getFiles(rtrim($dir, '/') . '/Resources/views/');

        $views = array();
        foreach ($files as $view) {
            $views[] = str_replace('/', ':', substr($view, strpos($view, '/Resources/views/') + 17));
        }

        return $this->render('CommtoolTemplateBundle:Default:view_files.html.twig', array(
                    'files' => $views
        ));
    }

    public function renderTemplateAction()
    {
        $view = $this->getRequest()->get('view');

        $response = $this->render($view);

        return $response;
    }

    public function saveAction($id)
    {
        $sections = $this->getRequest()->get('sections');

        $em = $this->getDoctrine()->getManager();

        $template = $em->getRepository('CommtoolTemplateBundle:Template')
                ->find($id);
        
        $template->getSections()->clear();
        
        $template->setSections($sections);
        
        $em->persist($template);
                
        $em->flush();
die(1);
//        return $this->render('CommtoolTemplateBundle:Default:test.html.twig', array(
//                    'section' => $section
//        ));
    }

    public function createAction()
    {
        $template = new Template();

        $template->setName($this->getRequest()->get('name'))
                ->setView($this->getRequest()->get('view'))
                ->setContent('dfsd')
                ->setThumbnail('dfsdfsd');

        $em = $this->getDoctrine()
                ->getManager();
        $em->persist($template);
        $em->flush();

        return new JsonResponse(array(
            'success' => true,
            'id' => $template->getId(),
        ));
    }

}
