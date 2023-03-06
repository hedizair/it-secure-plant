<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PreferenceRepository;

#[Route('/water_level')]
class WaterLevelController extends AbstractController
{
    #[Route('/refresh', name: 'app_water_level_refresh', methods: ['GET'])]
    public function refresh(PreferenceRepository $preferenceRepository): Response
    {
        $preference = $preferenceRepository->find(1);
        $ip = $preference->getIp();

        $client = HttpClient::create();
        $response = $client->request('GET', 'http://'.$ip.'/water_level/refresh');
        $result = $response->getContent();

        if($result == "Water level has been updated")
        {
            // sleep(3);
            return $this->redirectToRoute('app_water_level_refresh_temp', [], Response::HTTP_CREATED);
            // return $this->json('{}');
        }
        else{
            dd("ERREUR !");
        }

    }

    #[Route('/refresh/temp', name: 'app_water_level_refresh_temp', methods: ['GET'])]
    public function refreshTemp()
    {
        return $this->redirectToRoute('app_dashboard');
    }
}