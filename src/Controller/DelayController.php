<?php


namespace App\Controller;


use App\Entity\Delay;
use App\Entity\Remodeling;
use App\Form\DelayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/delay", name="delay_")
 */
class DelayController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $delay = new Delay();

        $form = $this->createForm(DelayType::class, $delay);
        $form->add('Create', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $delay = $form->getData();

            $remodeling = $this->getDoctrine()->getRepository(Remodeling::class)->find($request->query->get('remodeling'));
            if(!$remodeling) {
                throw $this->createNotFoundException(
                    'No remodeling found for id '.$request->query->get('remodeling')
                );
            }

            $delay->setRemodeling($remodeling);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($delay);
            $entityManager->flush();

            $this->addFlash(
                'success',
                '¡Demora añadida!'
            );

            return $this->redirectToRoute('remodeling_list');
        }

        return $this->render('delay/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $delay = $this->getDoctrine()->getRepository(Delay::class)->find($id);

        if(!$delay) {
            throw $this->createNotFoundException(
                'No delay found for id '.$id
            );
        }

        $form = $this->createForm(DelayType::class, $delay);
        $form
            ->add('note', TextareaType::class, [
                'attr' => ['rows' => 6, 'disabled' => true]
        ]   )
            ->add('days', NumberType::class, [
                'attr' => ['disabled' => true]
            ]);

        return $this->render('delay/show.html.twig', [
            'delay' => $delay,
            'form' => $form->createView()
        ]);
    }
}