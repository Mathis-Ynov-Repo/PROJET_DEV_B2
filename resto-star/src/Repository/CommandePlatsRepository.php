<?php

namespace App\Repository;

use App\Entity\CommandePlats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommandePlats|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandePlats|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandePlats[]    findAll()
 * @method CommandePlats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandePlatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandePlats::class);
    }

    // /**
    //  * @return CommandePlats[] Returns an array of CommandePlats objects
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
    public function findOneBySomeField($value): ?CommandePlats
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
