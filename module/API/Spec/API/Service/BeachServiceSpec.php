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
        $result = array(
            'city' => 'Miami',
            'name' => 'Coral bay',
        );

        $doctrineHydrator->hydrate($beachData, new Beach())->shouldBeCalled()->willReturn($beach);
        $beachRepository->addBeach($beach)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $doctrineHydrator->extract($beach)->willReturn($result);
        $this->addBeach($requestData)->shouldBeEqualTo($result);

    }

    function  it_return_a_list_of_beaches(
        BeachRepository $beachRepository,
        DoctrineHydrator $doctrineHydrator,
        EntityManager $entityManager,
        Beach $beach
    )
    {
        $beachData = array(
            'id'   => 1,
            'name' => 'Maria Beach',
            'slug' => 'maria-beach',
            'city' => 'Palermo'
        );

        $beachRepository->findAll()->shouldBeCalled()->willReturn(array($beach));
        $doctrineHydrator->extract($beach)->shouldBeCalled()->willReturn($beachData);

        $this->getBeaches()->shouldBeEqualTo(array($beachData));

    }
}
