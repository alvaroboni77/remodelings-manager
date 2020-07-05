<?php


namespace App\Controller;

use App\Entity\Remodeling;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $remodelings = $this->getDoctrine()->getRepository(Remodeling::class)->findAll();

        return $this->render('dashboard.html.twig', [
            'projects' => $remodelings
        ]);
    }
}