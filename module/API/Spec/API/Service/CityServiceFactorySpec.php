<?php

namespace Spec\API\Service;

use API\Entity\Repository\CityRepository;
use Doctrine\ORM\EntityManager;
use Phpro\DoctrineHydrationModule\Hydrator\DoctrineHydrator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

class CityServiceFactorySpec extends ObjectBehavior
{
    function it_implements_factory_interface()
    {
        $this->beAnInstanceOf('Zend\ServiceManager\FactoryInterface');
    }

    function it_create_a_beach_service(
        ServiceManager $serviceManager,
        CityRepository $cityRepository,
        EntityManager $entityManager,
        DoctrineHydrator $doctrineHydrator,
        HydratorPluginManager $hydratorPluginManager
    )
    {
        $serviceManager->get('doctrine.entitymanager.orm_default')->shouldBeCalled()->willReturn($entityManager);
        $entityManager->getRepository('API\Entity\City')->shouldBeCalled()->willReturn($cityRepository);
        $serviceManager->get('HydratorManager')->shouldBeCalled()->willReturn($hydratorPluginManager);
        $hydratorPluginManager->get('city_hydrator')->shouldBeCalled()->willReturn($doctrineHydrator);
        $this->createService($serviceManager)->shouldBeAnInstanceOf('API\Service\CityService');
    }
}
