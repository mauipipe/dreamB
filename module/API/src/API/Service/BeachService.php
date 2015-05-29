<?php
namespace API\Service;


use API\Entity\Beach;
use API\Entity\Repository\BeachRepository;
use API\Utility\Slugficator;
use Doctrine\ORM\EntityManager;
use Phpro\DoctrineHydrationModule\Hydrator\DoctrineHydrator;

class BeachService
{

    private $beachRepository;
    private $doctrineHydrator;
    private $entityManager;

    public function __construct(
        BeachRepository $beachRepository,
        DoctrineHydrator $doctrineHydrator,
        EntityManager $entityManager
    )
    {
        $this->beachRepository = $beachRepository;
        $this->doctrineHydrator = $doctrineHydrator;
        $this->entityManager = $entityManager;
    }

    public function addBeach(array $data)
    {

        $data['city'] = array(
            'id' => $data['city_id']
        );
        unset($data['city_id']);

        $beach = $this->doctrineHydrator->hydrate($data, new Beach());
        if (!$beach instanceof Beach) {
            throw new \RuntimeException('an error occurred while persisting beaches');
        }

        $beach->setSlug(Slugficator::createSlug($beach->getName()));
        $this->beachRepository->addBeach($beach);
        $this->entityManager->flush();
    }
}
