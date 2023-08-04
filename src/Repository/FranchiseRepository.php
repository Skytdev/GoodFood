<?php

namespace App\Repository;

use App\Entity\Franchise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Franchises|null find($id, $lockMode = null, $lockVersion = null)
 * @method Franchises|null findOneBy(array $criteria, array $orderBy = null)
 * @method Franchises[]    findAll()
 * @method Franchises[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Franchise::class);
    }

    /**
     * @return Franchise[] Returns an array of Franchise objects
     */
    public function findByCP($CP)
    {
        return $this->createQueryBuilder('f')
            ->join('f.citiesDelivery', 'c')
            ->andWhere('c.cp = :val')
            ->setParameter('val', $CP)
            ->orderBy('f.name', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Franchise
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
