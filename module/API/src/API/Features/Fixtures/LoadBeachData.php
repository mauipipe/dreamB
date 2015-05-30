<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Features\Fixtures;

use API\Entity\Beach;
use API\Entity\City;
use API\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBeachData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $beachFixture = array(
            array(
                'name' => 'Bay Beach',
                'slug' => 'bay-beach',
                'city'=>'san-francisco'
            ),
            array(
                'name' => 'Palermo Beach',
                'slug' => 'palermo-beach',
                'city'=>'palermo'
            ),
        );

        $beachReferences = array();
        foreach ($beachFixture as $beachFixture) {
            $beach = new Beach();
            $beach->setName($beachFixture['name']);
            $beach->setSlug($beachFixture['slug']);
            $beach->setCity(
                $this->getReference($beachFixture['city'])
            );

            $manager->persist($beach);
            $beachReferences[$beachFixture['slug']] = $beach;
            $manager->persist($beach);
        }

        $manager->flush();

        foreach($beachReferences as $referenceName => $beach){
            $this->addReference($referenceName, $beach);
        }
    }
}