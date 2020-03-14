<?php

namespace App\Repository;

use App\Entity\MenuDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MenuDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuDetails[]    findAll()
 * @method MenuDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuDetails::class);
    }

    // /**
    //  * @return MenuDetails[] Returns an array of MenuDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MenuDetails
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
