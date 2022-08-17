<?php

namespace App\Repository;

use App\Entity\People;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<People>
 *
 * @method People|null find($id, $lockMode = null, $lockVersion = null)
 * @method People|null findOneBy(array $criteria, array $orderBy = null)
 * @method People[]    findAll()
 * @method People[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeopleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, People::class);
    }

    public function add(People $entity, bool $flush = false): void
    {
        if ($this->alreadyExists($entity)) {
            throw new \RuntimeException('This people already exists !!', 400);
        }

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(People $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function alreadyExists(People $people): bool
    {
        $conn = $this->getEntityManager()->getConnection();
        $contact = $people->getContact();

        $sql = "SELECT * FROM people WHERE contact::jsonb @> '{\"firstname\": \"${contact['firstname']}\", \"lastname\": \"${contact['lastname']}\", \"email\": \"${contact['email']}\"}'::jsonb";
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();

        return !empty($result->fetchAllAssociative());
    }
}
