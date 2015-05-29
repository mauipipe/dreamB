<?php

namespace Spec\API\Service;

use API\Entity\Comment;
use API\Entity\Repository\CommentRepository;
use Doctrine\ORM\EntityManager;
use Phpro\DoctrineHydrationModule\Hydrator\DoctrineHydrator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentServiceSpec extends ObjectBehavior
{
    function let(
        CommentRepository $commentRepository,
        DoctrineHydrator $doctrineHydrator,
        EntityManager $entityManager
    )
    {
        $this->beConstructedWith($commentRepository, $doctrineHydrator, $entityManager);
    }

    function it_consumes_data_and_add_a_comment(
        CommentRepository $commentRepository,
        DoctrineHydrator $doctrineHydrator,
        EntityManager $entityManager,
        Comment $comment
    )
    {
        $requestData = array(
            'beach_id' => 1,
            'name'    => 'Gandalf',
            'last_name'=>'Grey',
            'description'=>'marvelous'
        );

        $commentData = array(
            'beach' => array(
                'id' => 1
            ),
            'name'    => 'Gandalf',
            'last_name'=>'Grey',
            'description'=>'marvelous'
        );

        $doctrineHydrator->hydrate($commentData, new Comment())->shouldBeCalled()->willReturn($comment);
        $commentRepository->addComment($comment)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->addComment($requestData);

    }
}
