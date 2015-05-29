<?php

namespace API\Service;

use API\Entity\Comment;
use API\Entity\Repository\CommentRepository;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator\HydratorInterface;

class CommentService
{

    private $commentRepository;
    private $doctrineHydrator;
    private $entityManager;

    public function __construct(
        CommentRepository $commentRepository,
        HydratorInterface $doctrineHydrator,
        EntityManager $entityManager)
    {
        $this->commentRepository = $commentRepository;
        $this->doctrineHydrator = $doctrineHydrator;
        $this->entityManager = $entityManager;
    }

    public function addComment(array $data)
    {
        $data['beach'] = array(
            'id' => $data['beach_id']
        );
        unset($data['beach_id']);

        $comment = $this->doctrineHydrator->hydrate($data, new Comment());
        if (!$comment instanceof Comment) {
            throw new \RuntimeException('an error occurred while persisting beaches');
        }
        $this->commentRepository->addComment($comment);
        $this->entityManager->flush();
    }
}
