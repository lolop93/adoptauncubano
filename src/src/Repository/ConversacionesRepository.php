<?php

namespace App\Repository;

use App\Entity\Conversaciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Conversaciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversaciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversaciones[]    findAll()
 * @method Conversaciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversaciones::class);
    }

    // /**
    //  * @return Conversaciones[] Returns an array of Conversaciones objects
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
    public function findOneBySomeField($value): ?Conversaciones
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
