<?php


namespace App\Controller;

use App\Entity\Architect;
use App\Form\ArchitectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/architect", name="architect_")
 */
class ArchitectController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function list()
    {
        return $this->render('architect/list.html.twig');
    }

    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $architect = new Architect();

        $form = $this->createForm(ArchitectType::class, $architect);
        $form->add('Create', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $architect = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($architect);
            $entityManager->flush();

            $this->addFlash(
                'success',
                '¡Arquitecto creado!'
            );

            return $this->redirectToRoute('architect_list');
        }

        return $this->render('architect/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}