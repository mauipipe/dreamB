<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Features\Fixtures;

use API\Entity\City;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCityData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {

        $cityFixture = array(
            array(
                'name' => 'San Francisco',
                'slug' => 'san-francisco'
            ),
            array(
                'name' => 'Palermo',
                'slug' => 'palermo'
            )
        );

        $cityReferences = array();
        foreach ($cityFixture as $cityFixture) {
            $city = new City();
            $city->setName($cityFixture['name']);
            $city->setSlug($cityFixture['slug']);
            $manager->persist($city);
            $cityReferences[$cityFixture['slug']] = $city;
            $manager->persist($city);
        }

        $manager->flush();

        foreach ($cityReferences as $referenceName => $city) {
            $this->addReference($referenceName, $city);
        }
    }
}