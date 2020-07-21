<?php


namespace App\Controller;

use App\Entity\Architect;
use App\Entity\Builder;
use App\Entity\Remodeling;
use App\Entity\TechnicalArchitect;
use App\Form\ArchitectType;
use App\Form\BuilderType;
use App\Form\RemodelingType;
use App\Form\TechnicalArchitectType;
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
    public function list()
    {
        $remodelings = $this->getDoctrine()->getRepository(Remodeling::class)->findAll();
        return $this->render('remodeling/list.html.twig', [
            'remodelings' => $remodelings
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

        $remodeling = new Remodeling();
        $builder = new Builder();
        $architect = new Architect();
        $technicalArchitect = new TechnicalArchitect();

        $form = $this->createForm(RemodelingType::class, $remodeling);
        $form->add('Create', SubmitType::class);

        $builderForm = $this->createForm(BuilderType::class, $builder);
        $architectForm = $this->createForm(ArchitectType::class, $architect);
        $technicalArchitectForm = $this->createForm(TechnicalArchitectType::class, $technicalArchitect);

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
            'form' => $form->createView(),
            'builderForm' => $builderForm->createView(),
            'architectForm' => $architectForm->createView(),
            'technicalArchitectForm' => $technicalArchitectForm->createView()
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

        $remodeling = $this->getDoctrine()->getRepository(Remodeling::class)->find($id);

        $builder = new Builder();
        $architect = new Architect();
        $technicalArchitect = new TechnicalArchitect();

        $form = $this->createForm(RemodelingType::class, $remodeling);
        $form->add('Update', SubmitType::class);

        $builderForm = $this->createForm(BuilderType::class, $builder);
        $architectForm = $this->createForm(ArchitectType::class, $architect);
        $technicalArchitectForm = $this->createForm(TechnicalArchitectType::class, $technicalArchitect);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $remodeling = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($remodeling);
            $entityManager->flush();

            $this->addFlash(
                'info',
                '¡Reforma modificada!'
            );

            return $this->redirectToRoute('remodeling_list');
        }

        return $this->render('remodeling/edit.html.twig', [
            'remodeling' => $remodeling,
            'form' => $form->createView(),
            'builderForm' => $builderForm->createView(),
            'architectForm' => $architectForm->createView(),
            'technicalArchitectForm' => $technicalArchitectForm->createView()
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
        $remodeling = $entityManager->getRepository(Remodeling::class)->find($id);

        if(!$remodeling) {
            throw $this->createNotFoundException(
                'No remodeling found for id '.$id
            );
        }

        $entityManager->remove($remodeling);
        $entityManager->flush();

        $this->addFlash(
            'danger',
            '¡Reforma eliminada!'
        );

        return new Response('Remodeling deleted', 200);
    }

}