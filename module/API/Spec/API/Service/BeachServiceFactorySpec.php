<?php

namespace Spec\API\Service;

use API\Entity\Repository\BeachRepository;
use Doctrine\ORM\EntityManager;
use Phpro\DoctrineHydrationModule\Hydrator\DoctrineHydrator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\HydratorPluginManager;


class BeachServiceFactorySpec extends ObjectBehavior
{
    function it_implements_factory_interface()
    {
        $this->beAnInstanceOf('Zend\ServiceManager\FactoryInterface');
    }

    function it_create_a_beach_service(
        ServiceManager $serviceManager,
        HydratorPluginManager $hydratorPluginManager,
        BeachRepository $beachRepository,
        EntityManager $entityManager,
        DoctrineHydrator $doctrineHydrator
    )
    {
        $serviceManager->get('doctrine.entitymanager.orm_default')->shouldBeCalled()->willReturn($entityManager);
        $entityManager->getRepository('API\Entity\Beach')->shouldBeCalled()->willReturn($beachRepository);
        $serviceManager->get('HydratorManager')->shouldBeCalled()->willReturn($hydratorPluginManager);
        $hydratorPluginManager->get('beach_hydrator')->shouldBeCalled()->willReturn($doctrineHydrator);
        $this->createService($serviceManager)->shouldBeAnInstanceOf('API\Service\BeachService');
    }
}
