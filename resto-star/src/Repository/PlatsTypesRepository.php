<?php

namespace App\Repository;

use App\Entity\PlatsTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlatsTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlatsTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlatsTypes[]    findAll()
 * @method PlatsTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatsTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlatsTypes::class);
    }

    // /**
    //  * @return PlatsTypes[] Returns an array of PlatsTypes objects
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
    public function findOneBySomeField($value): ?PlatsTypes
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
