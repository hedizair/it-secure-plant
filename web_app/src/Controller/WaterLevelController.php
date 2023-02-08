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
            return $this->redirectToRoute('app_dashboard', [], Response::HTTP_SEE_OTHER);
        }
        else{
            dd("ERREUR !");
        }
    }
}