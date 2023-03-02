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
        //$ip = $preference->getIp();
        $ip = $preference->getIp();

        $client = HttpClient::create();
        $response = $client->request('GET', 'http://'.$ip.'/air_condition/refresh');
        //$items = $response->toArray();
        $items = $response->getContent();

        $airCondition = new AirCondition();
        date_default_timezone_set('Europe/Paris');
        $airCondition->setDate(new DateTimeImmutable(date('Y-m-d h:i:s')));
        $airCondition->setTemperature(20);
        $airCondition->setHumidity(75);
        $airCondition->setAtmosphericPressure(3.44);
        $airCondition->setArea($preference->getArea());
        $airConditionRepository->save($airCondition, true);

        return $this->redirectToRoute('app_dashboard', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/lastId', name: 'app_air_condition_lastId', methods: ['GET'])]
    public function getLastId(AirConditionRepository $airConditionRepository) {
        $value = $airConditionRepository->findOneBy([],['id'=>'desc']);
        return $this->json($value->getId());
    }
}