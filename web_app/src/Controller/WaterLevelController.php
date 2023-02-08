<?php

namespace App\Controller;

use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PreferenceRepository;
use App\Entity\WaterLevel;
use App\Repository\WaterLevelRepository;

#[Route('/water_level')]
class WaterLevelController extends AbstractController
{
    #[Route('/refresh', name: 'app_water_level_refresh', methods: ['GET'])]
    public function refresh(PreferenceRepository $preferenceRepository, WaterLevelRepository $waterLevelRepository): Response
    {
        $preference = $preferenceRepository->find(1);
        //$ip = $preference->getIp();
        $ip = "lionel.buathier.perso.univ-lyon1.fr/time";

        $client = HttpClient::create();
        $response = $client->request('GET', 'http://'.$ip.'/');
        //$items = $response->toArray();
        $items = $response->getContent();

        $waterLevel = new WaterLevel();
        date_default_timezone_set('Europe/Paris');
        $waterLevel->setDate(new DateTimeImmutable(date('Y-m-d h:i:s')));
        $waterLevel->setLevel(60);
        $waterLevelRepository->save($waterLevel, true);

        return $this->redirectToRoute('app_dashboard', [], Response::HTTP_SEE_OTHER);
    }
}