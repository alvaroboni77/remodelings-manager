<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/builder", name="builder_")
 */
class BuilderController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function builderList()
    {
        return $this->render('builder/list.html.twig');
    }

    /**
     * @Route("/new", name="new")
     */
    public function builderNew()
    {
        return $this->render('builder/new.html.twig');
    }

}