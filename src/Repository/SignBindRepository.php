<?php

namespace App\Repository;

use App\Entity\SignBind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SignBind|null find($id, $lockMode = null, $lockVersion = null)
 * @method SignBind|null findOneBy(array $criteria, array $orderBy = null)
 * @method SignBind[]    findAll()
 * @method SignBind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignBindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SignBind::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SignBind $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(SignBind $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function flushAll(): void
    {
        $this->_em->flush();
    }

    // /**
    //  * @return SignBind[] Returns an array of SignBind objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SignBind
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
