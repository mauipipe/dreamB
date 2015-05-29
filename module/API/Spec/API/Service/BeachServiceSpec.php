<?php

namespace Spec\API\Service;

use API\Entity\Beach;
use API\Entity\Repository\BeachRepository;
use Doctrine\ORM\EntityManager;
use Phpro\DoctrineHydrationModule\Hydrator\DoctrineHydrator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BeachServiceSpec extends ObjectBehavior
{
    function let(
        BeachRepository $beachRepository,
        DoctrineHydrator $doctrineHydrator,
        EntityManager $entityManager
    )
    {
        $this->beConstructedWith($beachRepository, $doctrineHydrator, $entityManager);
    }

    function it_consumes_data_and_add_beach(
        BeachRepository $beachRepository,
        DoctrineHydrator $doctrineHydrator,
        EntityManager $entityManager,
        Beach $beach
    )
    {
        $requestData = array(
            'city_id' => 1,
            'name'    => 'Coral bay',
        );
        $beachData = array(
            'city' => array(
                'id' => 1
            ),
            'name' => 'Coral bay'
        );

        $doctrineHydrator->hydrate($beachData, new Beach())->shouldBeCalled()->willReturn($beach);
        $beachRepository->addBeach($beach)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->addBeach($requestData);

    }
}
