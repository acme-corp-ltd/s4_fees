<?php

namespace App\Repository;

use App\Entity\Fee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Fee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fee[]    findAll()
 * @method Fee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fee::class);
    }

    // /**
    //  * @return Fee[] Returns an array of Fee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @param $category
     * @param $amount
     * @return Fee|null
     * @throws NonUniqueResultException
     */
    public function findOneByCategoryAmount($category, $amount): ?Fee
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.category = :category')
            ->andWhere('f.limLow <= :amount')
            ->andWhere('f.limTop >= :amount')
            ->setParameter('category', $category)
            ->setParameter('amount', $amount)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
