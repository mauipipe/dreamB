<?php

namespace API\Service;

use API\Entity\Repository\CityRepository;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CityService
{

    private $cityRepository;
    private $cityHydrator;

    public function __construct(
        CityRepository $cityRepository,
        HydratorInterface $cityHydrator)
    {
        $this->cityRepository = $cityRepository;
        $this->cityHydrator = $cityHydrator;
    }

    public function getCities()
    {
        $cities = $this->cityRepository->findAll();
        $result = array();

        foreach ($cities as $city) {
            $cityData = $this->cityHydrator->extract($city);
            unset($cityData['beaches']);
            $result[] = $cityData;
        }

        return $result;
    }
}
