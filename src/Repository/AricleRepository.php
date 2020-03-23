<?php

namespace App\Repository;

use App\Entity\Aricle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Aricle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aricle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aricle[]    findAll()
 * @method Aricle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AricleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aricle::class);
    }

    // /**
    //  * @return Aricle[] Returns an array of Aricle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Aricle
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
