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

    // /**
    //  * @return Movings[] Returns an array of Movings objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Movings
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
