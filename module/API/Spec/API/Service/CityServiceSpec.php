<?php

namespace Spec\API\Service;

use API\Entity\City;
use API\Entity\Repository\CityRepository;
use Phpro\DoctrineHydrationModule\Hydrator\DoctrineHydrator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CityServiceSpec extends ObjectBehavior
{

    function let(CityRepository $cityRepository, DoctrineHydrator $doctrineHydrator)
    {
        $this->beConstructedWith($cityRepository, $doctrineHydrator);
    }

    function it_return_a_list_of_comments(
        CityRepository $cityRepository,
        City $city,
        DoctrineHydrator $doctrineHydrator
    )
    {
        $cityData = array(
            'id'   => 1,
            'city' => 'Palermo',
            'slug' => 'palermo'
        );

        $cityRepository->findAll()->shouldBeCalled()->willReturn(array($city));
        $doctrineHydrator->extract($city)->shouldBeCalled()->willReturn($cityData);

        $this->getCities()->shouldBeEqualTo(array($cityData));
    }
}
