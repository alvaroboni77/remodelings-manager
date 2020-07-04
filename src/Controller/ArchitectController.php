<?php


namespace App\Controller;

use App\Entity\Architect;
use App\Entity\TechnicalArchitect;
use App\Form\ArchitectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
        $architects = $this->getDoctrine()->getRepository(Architect::class)->findAll();
        $technicalArchitects = $this->getDoctrine()->getRepository(TechnicalArchitect::class)->findAll();

        return $this->render('architect/list.html.twig', [
            'architects' => $architects,
            'technicalArchitects' => $technicalArchitects
        ]);
    }

    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
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

    /**
     * @Route("/edit/{id}", name="edit")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $architect = $this->getDoctrine()->getRepository(Architect::class)->find($id);
        if(!$architect) {
            throw $this->createNotFoundException(
                'No architect found for id '.$id
            );
        }

        $form = $this->createForm(ArchitectType::class, $architect);
        $form->add('Update', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $builder = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($builder);
            $entityManager->flush();

            $this->addFlash(
                'warning',
                '¡Arquitecto modificado!'
            );

            return $this->redirectToRoute('architect_list');
        }

        return $this->render('architect/edit.html.twig', [
            'architect' => $architect,
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
        $builder = $entityManager->getRepository(Architect::class)->find($id);
        if(!$builder) {
            throw $this->createNotFoundException(
                'No builder found for id '.$id
            );
        }

        $entityManager->remove($builder);
        $entityManager->flush();

        $this->addFlash(
            'danger',
            '¡Arquitecto eliminado!'
        );

        return new Response('Architect deleted', 200);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function createFromRemodeling(Request $request, ValidatorInterface $validator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $architect = new Architect();
        $architect->setName($request->request->get('name'));
        $architect->setEmail($request->request->get('email'));

        $errors = $validator->validate($architect);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($architect);
            $entityManager->flush();

            return new Response('¡Arquitecto creado!', 201);
        }
    }

}