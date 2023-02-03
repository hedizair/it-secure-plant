<?php

namespace App\Controller;

use App\Entity\AirCondition;
use App\Form\AirConditionType;
use App\Repository\AirConditionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/air/condition')]
#[ApiRessource]
class AirConditionController extends AbstractController
{
    #[Route('/', name: 'app_air_condition_index', methods: ['GET'])]
    public function index(AirConditionRepository $airConditionRepository): Response
    {
        return $this->render('air_condition/index.html.twig', [
            'air_conditions' => $airConditionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_air_condition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AirConditionRepository $airConditionRepository): Response
    {
        $airCondition = new AirCondition();
        $form = $this->createForm(AirConditionType::class, $airCondition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $airConditionRepository->save($airCondition, true);

            return $this->redirectToRoute('app_air_condition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('air_condition/new.html.twig', [
            'air_condition' => $airCondition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_air_condition_show', methods: ['GET'])]
    public function show(AirCondition $airCondition): Response
    {
        return $this->render('air_condition/show.html.twig', [
            'air_condition' => $airCondition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_air_condition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AirCondition $airCondition, AirConditionRepository $airConditionRepository): Response
    {
        $form = $this->createForm(AirConditionType::class, $airCondition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $airConditionRepository->save($airCondition, true);

            return $this->redirectToRoute('app_air_condition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('air_condition/edit.html.twig', [
            'air_condition' => $airCondition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_air_condition_delete', methods: ['POST'])]
    public function delete(Request $request, AirCondition $airCondition, AirConditionRepository $airConditionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$airCondition->getId(), $request->request->get('_token'))) {
            $airConditionRepository->remove($airCondition, true);
        }

        return $this->redirectToRoute('app_air_condition_index', [], Response::HTTP_SEE_OTHER);
    }
}
