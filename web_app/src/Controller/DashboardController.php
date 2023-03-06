<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PreferenceRepository;
use App\Repository\PlantRepository;
use App\Repository\AreaRepository;
use App\Repository\IrrigationRepository;
use App\Repository\AirConditionRepository;
use App\Repository\WaterLevelRepository;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(PreferenceRepository $preferenceRepository, PlantRepository $plantRepository, AreaRepository $areaRepository, IrrigationRepository $irrigationRepository, AirConditionRepository $airConditionRepository, WaterLevelRepository $waterLevelRepository): Response
    {
        $preference = $preferenceRepository->find(1);
        $plant = $plantRepository->find($preference->getPlant());
        $area = $areaRepository->find($preference->getArea());
        $airCondition = $airConditionRepository->findOneBy(["area_id" => $area], ['id' => 'desc']);
        $waterLevel = $waterLevelRepository->findOneBy([], ['id' => 'desc']);

        $irrigations = $irrigationRepository->findBy([
            "plant_id" => $plant->getId(),
            "area_id" => $area->getId()
        ], ['id' => 'desc']);

        if(count($irrigations) > 0)
        {
            $irrigationAirConditions = array();

            foreach($irrigations as $irrigation)
            {
                $airConditionTmp = $airConditionRepository->find($irrigation->getAirConditionId());

                $irrigationAirConditions[$irrigation->getId()] = $airConditionTmp->getTemperature() . " °C / " . $airConditionTmp->getHumidity() . " % / " . $airConditionTmp->getAtmosphericPressure() . " Pa";
            }
        }

        // dd($irrigations);
        // dd($airCondition);

        return $this->render('dashboard/index.html.twig', [
            'plant' => $plant,
            'area' => $area,
            'preference' => $preference,
            'air_condition' => $airCondition,
            'water_level' => $waterLevel,
            'irrigations' => $irrigations,
            'irrigationAirConditions' => $irrigationAirConditions
        ]);
    }
}