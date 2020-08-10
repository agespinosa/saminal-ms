<?php

namespace App\Repository;

use App\Entity\Uel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Uel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Uel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Uel[]    findAll()
 * @method Uel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Uel::class);
    }

    // /**
    //  * @return Uel[] Returns an array of Uel objects
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
    public function findOneBySomeField($value): ?Uel
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
