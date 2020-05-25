<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/architect", name="architect_")
 */
class ArchitectController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function architectList()
    {
        return $this->render('architect/list.html.twig');
    }

    /**
     * @Route("/new", name="new")
     */
    public function architectNew()
    {
        return $this->render('architect/new.html.twig');
    }

}