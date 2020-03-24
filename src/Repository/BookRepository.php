<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getByWordInResume()
    {
        //je defini le mot a rechercher dans la colonne résume
        $word = 'japon';

        //jutilise le queryBuilder qui me permet de créer mes requete select en base de donnée
        //je place en parametre une letttre ou un mot qui fera office d'alias pour ma table
        $queryBuilder = $this->createQueryBuilder('book');
        //je défini une clause WHERE avec un like dans la column résume
        $query = $queryBuilder->select('book')
            ->where('book.resume LIKE :word')
            //j'utilise set parameter pour que la variable soit sécurisé
            ->setParameter('word', '%'.$word.'%')
            ->getQuery();

        //j'execute puis je retourne le résultat
        $results = $query->getResult();
        return $results;
    }
}
