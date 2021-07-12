<?php

namespace App\Repository;

use App\Entity\UserAttributes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserAttributes|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAttributes|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAttributes[]    findAll()
 * @method UserAttributes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAttributesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAttributes::class);
    }

    // /**
    //  * @return UserAttributes[] Returns an array of UserAttributes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserAttributes
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
