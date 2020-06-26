<?php


namespace App\Controller;

use App\Entity\Remodeling;
use App\Form\RemodelingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $remodeling = new Remodeling();

        $form = $this->createForm(RemodelingType::class, $remodeling);
        $form->add('Create', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $siteProject = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($siteProject);
            $entityManager->flush();

            $this->addFlash(
                'success',
                '¡Reforma creada!'
            );

            return $this->redirectToRoute('remodeling_list');
        }

        return $this->render('remodeling/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}