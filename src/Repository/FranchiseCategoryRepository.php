<?php

namespace App\Repository;

use App\Entity\FranchiseCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FranchiseCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FranchiseCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FranchiseCategory[]    findAll()
 * @method FranchiseCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchiseCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FranchiseCategory::class);
    }

    // /**
    //  * @return FranchiseCategory[] Returns an array of FranchiseCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FranchiseCategorys
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
