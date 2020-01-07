<?php

namespace App\Repository;

use App\Entity\UsersMovings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UsersMovings|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersMovings|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersMovings[]    findAll()
 * @method UsersMovings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersMovingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersMovings::class);
    }

    // /**
    //  * @return UsersMovings[] Returns an array of UsersMovings objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsersMovings
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
