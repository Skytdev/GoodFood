<?php

namespace App\Repository;

use App\Entity\PurchaseIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PurchaseIngredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurchaseIngredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurchaseIngredient[]    findAll()
 * @method PurchaseIngredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseIngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PurchaseIngredient::class);
    }

    // /**
    //  * @return PurchaseIngredient[] Returns an array of PurchaseIngredient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PurchaseIngredient
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
