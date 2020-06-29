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
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @Route("/edit/{id}", name="edit")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, int $id)
    {
        $technicalArchitect = $this->getDoctrine()->getRepository(TechnicalArchitect::class)->find($id);

        if(!$technicalArchitect) {
            throw $this->createNotFoundException(
                'No technical arquitect found for id '.$id
            );
        }

        $form = $this->createForm(TechnicalArchitectType::class, $technicalArchitect);
        $form->add('Update', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $technicalArchitect = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($technicalArchitect);
            $entityManager->flush();

            $this->addFlash(
                'warning',
                '¡Arquitecto técnico modificado!'
            );

            return $this->redirectToRoute('architect_list');
        }

        return $this->render('technical-architect/show.html.twig', [
            'technicalArchitect' => $technicalArchitect,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $technicalArchitect = $entityManager->getRepository(TechnicalArchitect::class)->find($id);

        if(!$technicalArchitect) {
            throw $this->createNotFoundException(
                'No technical architect found for id '.$id
            );
        }

        $entityManager->remove($technicalArchitect);
        $entityManager->flush();

        $this->addFlash(
            'danger',
            '¡Arquitecto técnico eliminado!'
        );

        return new Response('Technical architect deleted', 200);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function technicalArchitectCreate(Request $request, ValidatorInterface $validator): Response
    {
        $technicalArchitect = new TechnicalArchitect();
        $technicalArchitect->setName($request->request->get('name'));
        $technicalArchitect->setEmail($request->request->get('email'));

        $errors = $validator->validate($technicalArchitect);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($technicalArchitect);
            $entityManager->flush();

            return new Response('¡Arquitecto ténico creado!', 200);
        }
    }
}