<?php

namespace Optime\Commtool\TemplateBundle\Controller;

use Optime\Commtool\TemplateBundle\Entity\Template;
use Optime\Commtool\TemplateBundle\Locator\FilesBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function indexAction($page = 1)
    {
        $templates = $this->getDoctrine()
                ->getManager()
                ->getRepository('CommtoolTemplateBundle:Template')
                ->findAll();

        return $this->render('CommtoolTemplateBundle:Default:index.html.twig', array(
                    'templates' => $templates,
        ));
    }

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


        array_unshift($bundles, '__main__');

        return $this->render('CommtoolTemplateBundle:Default:selectTemplate.html.twig', array(
                    'bundles' => $bundles,
        ));
    }

    public function getFilesFromViewAction($bundle)
    {
        if ('__main__' === $bundle) {
            $bundleName = ':';
        } else {
            $bundleName = $bundle . ':';
        }
        
        $bundle = preg_replace('/.+(Bundle)$/', '', $bundle); //le quitamos el sufijo si lo tiene

        $paths = $this->get('twig.loader')->getPaths($bundle);


        $views = FilesBundle::getFiles($paths[0], $bundleName);

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

    /**
     * @ParamConverter("template", class="CommtoolTemplateBundle:Template")
     */
    public function saveAction(Template $template)
    {
        $sections = $this->getRequest()->get('sections');

        $em = $this->getDoctrine()->getManager();

        $template->getSections()->clear();

        $template->setSections($sections);
        $em->persist($template);
        $em->flush();

        return new Response(1);
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
