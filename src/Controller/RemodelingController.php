<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/remodeling", name="remodeling_")
 */
class RemodelingController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function remodelingList()
    {
        return $this->render('remodeling/list.html.twig');
    }

    /**
     * @Route("/new", name="new")
     */
    public function remodelingNew()
    {
        return $this->render('remodeling/new.html.twig');
    }

}