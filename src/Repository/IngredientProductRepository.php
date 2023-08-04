<?php

namespace App\Repository;

use App\Entity\IngredientProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IngredientProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientProduct[]    findAll()
 * @method IngredientProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientProduct::class);
    }

    // /**
    //  * @return IngredientProduct[] Returns an array of IngredientProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IngredientProduct
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
