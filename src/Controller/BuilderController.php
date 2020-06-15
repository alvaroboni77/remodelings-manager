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
        return $this->render('builder/list.html.twig');
    }

    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
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

}