<?php
/**
 * Created by David Contavalli <david.contavalli@gmail.com>
 */

namespace API\Features\Fixtures;

use API\Entity\City;
use API\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCommentData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $commentFixture = array(
            array(
                'name' => 'Gus',
                'last_name' => 'Mc Duck',
                'description'=>'test',
                'beach'=>'bay-beach',
                'reference_name'=>'gus-comment'
            ),
            array(
                'name' => 'Mimmo',
                'last_name' => 'Rossi',
                'description'=>'test',
                'beach'=>'palermo-beach',
                'reference_name'=>'mimmo-comment'
            )
        );

        $commentReferences = array();
        foreach ($commentFixture as $commentFixture) {
            $comment = new Comment();
            $comment->setName($commentFixture['name']);
            $comment->setLastName($commentFixture['last_name']);
            $comment->setDescription($commentFixture['description']);
            $comment->setBeach(
                $this->getReference($commentFixture['beach'])
            );
            $commentReferences[$commentFixture['reference_name']] = $comment;
            $manager->persist($comment);
        }

        $manager->flush();

        foreach($commentReferences as $referenceName => $comment){
            $this->addReference($referenceName, $comment);
        }
    }
}