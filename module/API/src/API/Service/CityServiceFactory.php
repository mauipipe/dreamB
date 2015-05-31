<?php

namespace API\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CityServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hm = $serviceLocator->get('HydratorManager');
        $cityHydrator = $hm->get('city_hydrator');

        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $cityRepository = $em->getRepository('API\Entity\City');

        return new CityService($cityRepository, $cityHydrator);
    }
}
