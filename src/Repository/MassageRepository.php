<?php

namespace App\Repository;

use App\Entity\Massage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Massage>
 *
 * @method Massage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Massage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Massage[]    findAll()
 * @method Massage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MassageRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Massage::class);
  }

  public function save(Massage $entity, bool $flush = false): void
  {
    $this->getEntityManager()->persist($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  public function remove(Massage $entity, bool $flush = false): void
  {
    $this->getEntityManager()->remove($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  //    /**
  //     * @return Massage[] Returns an array of Massage objects
  //     */
  //    public function findByExampleField($value): array
  //    {
  //        return $this->createQueryBuilder('m')
  //            ->andWhere('m.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->orderBy('m.id', 'ASC')
  //            ->setMaxResults(10)
  //            ->getQuery()
  //            ->getResult()
  //        ;
  //    }

  //    public function findOneBySomeField($value): ?Massage
  //    {
  //        return $this->createQueryBuilder('m')
  //            ->andWhere('m.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->getQuery()
  //            ->getOneOrNullResult()
  //        ;
  //    }
}
