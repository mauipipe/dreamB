<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Features\Fixtures;

use API\Entity\City;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCityData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cityFixtures = array(
            array(
                'name' => 'San Francisco',
                'slug' => 'san-francisco'
            ),
            array(
                'name' => 'Treviso',
                'slug' => 'treviso'
            )
        );

        foreach ($cityFixtures as $cityFixture) {
            $city = new City();
            $city->setName($cityFixture['name']);
            $city->setSlug($cityFixture['slug']);
            $manager->persist($city);
        }

        $manager->flush();
    }
}