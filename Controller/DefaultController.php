<?php

namespace Optime\Commtool\TemplateBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Optime\Commtool\TemplateBundle\Entity\Template;
use Optime\Commtool\TemplateBundle\Locator\FilesBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        if (function_exists('mb_stripos')) {
            $posrFunction = 'mb_strripos';
            $substrFunction = 'mb_substr';
        } else {
            $posrFunction = 'strripos';
            $substrFunction = 'substr';
        }

        $twig = $this->get('twig_string');
//
        $view = 'CommtoolTemplateBundle::template_test.html.twig';
//
        $content = $twig->render($view);
        
        $newContent = $this->getRequest()->get('content');

        if (preg_match('/<body[^>]*>/im', $content)) {
            $content = preg_replace('/(<body[^>]*>)(.*?)(<\/body>)/im', "$1{$newContent}$3", $content);
        }
        die($content);

        $content = $substrFunction($content, 0, $pos) . $html . $substrFunction($content, $pos);
        $response->setContent($content);

        $section = $this->get('template_section_factory')->getType('singleline');

        return $this->render('CommtoolTemplateBundle:Default:test.html.twig', array(
                    'section' => $section
        ));
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
