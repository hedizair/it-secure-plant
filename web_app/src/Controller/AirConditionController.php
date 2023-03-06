<?php

namespace App\Controller;

use App\Entity\AirCondition;
use App\Repository\AirConditionRepository;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Preference;
use App\Repository\PreferenceRepository;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

#[Route('/air_condition')]
class AirConditionController extends AbstractController
{
    #[Route('/refresh', name: 'app_air_condition_refresh', methods: ['GET'])]
    public function refresh(PreferenceRepository $preferenceRepository, AirConditionRepository $airConditionRepository): Response
    {
        $preference = $preferenceRepository->find(1);
        $ip = $preference->getIp();

        $client = HttpClient::create();
        $response = $client->request('GET', 'http://'.$ip.'/air_condition/refresh');
        $result = $response->getContent();

        if($result == "Air condition has been updated")
        {
            return $this->redirectToRoute('app_air_condition_refresh_temp', [], Response::HTTP_CREATED);
        }
        else{
            dd("ERREUR !");
        }

    }
    #[Route('/lastId', name: 'app_air_condition_lastId', methods: ['GET'])]
    public function getLastId(AirConditionRepository $airConditionRepository) {
        $value = $airConditionRepository->findOneBy([],['id'=>'desc']);
        return $this->json($value->getId());
    }

    #[Route('/refresh/temp', name: 'app_air_condition_refresh_temp', methods: ['GET'])]
    public function refreshTemp()
    {
        return $this->redirectToRoute('app_dashboard');
    }
}