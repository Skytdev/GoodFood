<?php

namespace App\Repository;

use App\Entity\FactureRow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FactureRow|null find($id, $lockMode = null, $lockVersion = null)
 * @method FactureRow|null findOneBy(array $criteria, array $orderBy = null)
 * @method FactureRow[]    findAll()
 * @method FactureRow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FactureRow::class);
    }

    // /**
    //  * @return FactureRow[] Returns an array of FactureRow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FactureRow
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
