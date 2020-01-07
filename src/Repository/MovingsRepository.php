<?php

namespace App\Repository;

use App\Entity\Movings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Movings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movings[]    findAll()
 * @method Movings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movings::class);
    }

    public function findByUser($user, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->createQueryBuilder('b')
            ->addSelect('m')
            ->leftJoin('b.users', 'm')

            ->where('m.user=:user')
            ->setParameter('user', $user)

            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
}
