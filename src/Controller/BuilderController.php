<?php


namespace App\Controller;


use App\Entity\Builder;
use App\Form\BuilderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/builder", name="builder_")
 */
class BuilderController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function list()
    {
        $builders = $this->getDoctrine()->getRepository(Builder::class)->findAll();

        return $this->render('builder/list.html.twig', [
            'builders' => $builders
        ]);
    }

    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $builder = new Builder();

        $form = $this->createForm(BuilderType::class, $builder);
        $form->add('Create', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $builder = $form->getData(); // Get submitted data

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($builder);
            $entityManager->flush();

            $this->addFlash(
                'success',
                '¡Constructor añadido!'
            );

            return $this->redirectToRoute('builder_list');
        }

        return $this->render('builder/new.html.twig', [
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

        $builder = $this->getDoctrine()->getRepository(Builder::class)->find($id);

        if(!$builder) {
            throw $this->createNotFoundException(
                'No builder found for id '.$id
            );
        }

        $form = $this->createForm(BuilderType::class, $builder);
        $form->add('Update', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $builder = $form->getData(); // Get submitted data

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($builder);
            $entityManager->flush();

            $this->addFlash(
                'warning',
                '¡Constructor modificado!'
            );

            return $this->redirectToRoute('builder_list');
        }

        return $this->render('builder/edit.html.twig', [
            'builder' => $builder,
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
        $builder = $entityManager->getRepository(Builder::class)->find($id);

        if(!$builder) {
            throw $this->createNotFoundException(
                'No builder found for id '.$id
            );
        }

        $entityManager->remove($builder);
        $entityManager->flush();

        $this->addFlash(
            'danger',
            '¡Constructor eliminado!'
        );

        return new Response('Builder deleted', 200);
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

        $builder = new Builder();
        $builder->setName($request->request->get('name'));
        $builder->setEmail($request->request->get('email'));
        $builder->setCompany($request->request->get('company'));

        $errors = $validator->validate($builder);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        } else {
            // Save new architect into DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($builder);
            $entityManager->flush();

            return new Response('¡Constructor creado!', 200);
        }
    }
}