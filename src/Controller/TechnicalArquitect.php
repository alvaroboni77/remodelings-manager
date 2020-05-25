<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/technical-architect", name="technical_architect_")
 */
class TechnicalArquitect extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function technicalArchitectNew()
    {
        return $this->render('technical-architect/new.html.twig');
    }

}