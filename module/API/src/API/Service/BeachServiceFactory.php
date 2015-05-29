<?php

namespace API\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BeachServiceFactory implements FactoryInterface
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
        $beachHydrator = $hm->get('beach_hydrator');

        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $beachRepository = $em->getRepository('API\Entity\Beach');
        return new BeachService($beachRepository,$beachHydrator,$em);

    }
}
