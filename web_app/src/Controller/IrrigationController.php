<?php

namespace App\Controller;

use App\Entity\AirCondition;
use App\Entity\Irrigation;
use App\Repository\AirConditionRepository;
use App\Repository\IrrigationRepository;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Preference;
use App\Repository\PreferenceRepository;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

#[Route('/irrigation')]
class IrrigationController extends AbstractController
{
    #[Route('/lastId', name: 'irrigation_lastId', methods: ['GET'])]
    public function getLastId(IrrigationRepository $irrigation) {
        $value = $irrigation->findOneBy([],['id'=>'desc']);
        return $this->json($value->getId());
    }

    #[Route('/end/{id}', name: 'irrigation_end', methods: ['POST'])]
    public function end(IrrigationRepository $irrigationRepository, int $id, Request $request) {
        $irrigation = $irrigationRepository->findOneBy(['id'=>$id]);
        $startDate = $irrigation->getWateringStartDate();
        $endDate = new \DateTime(json_decode($request->getContent(), true)['wateringEndDate']);

        $duration = ($endDate->getTimestamp() - $startDate->getTimestamp());

        $irrigation->setWateringEndDate($endDate);
        $irrigation->setDuration($duration);
        $irrigationRepository->save($irrigation, true);
        return $this->json('{}');
    }
}