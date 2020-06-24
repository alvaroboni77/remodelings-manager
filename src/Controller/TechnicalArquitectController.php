<?php

namespace App\Controller;

use App\Entity\TechnicalArchitect;
use App\Form\TechnicalArchitectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/technical-architect", name="technical_architect_")
 */
class TechnicalArquitectController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $technicalArchitect = new TechnicalArchitect();

        $form = $this->createForm(TechnicalArchitectType::class, $technicalArchitect);
        $form->add('Create', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $technicalArchitect = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($technicalArchitect);
            $entityManager->flush();

            $this->addFlash(
                'success',
                '¡Arquitecto técnico creado!'
            );

            return $this->redirectToRoute('architect_list');
        }

        return $this->render('technical-architect/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}