<?php

namespace App\Repository;

use App\Entity\TicketRow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TicketRow|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketRow|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketRow[]    findAll()
 * @method TicketRow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicketRow::class);
    }

    // /**
    //  * @return TicketRow[] Returns an array of TicketRow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TicketRow
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
