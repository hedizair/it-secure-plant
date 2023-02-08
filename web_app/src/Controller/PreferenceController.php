<?php

namespace App\Controller;

use App\Entity\Preference;
use App\Form\PreferenceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PreferenceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Route('/preference')]
class PreferenceController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_preference_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Preference $preference, PreferenceRepository $preferenceRepository): Response
    {
        $form = $this->createForm(PreferenceType::class, $preference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $preferenceRepository->save($preference, true);
            return $this->redirectToRoute('app_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('preference/edit.html.twig', [
            'preference' => $preference,
            'form' => $form,
        ]);
    }
}