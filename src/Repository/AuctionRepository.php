<?php

namespace App\Repository;

use App\Entity\Auction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Auction>
 *
 * @method Auction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auction[]    findAll()
 * @method Auction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auction::class);
    }


    public function findVisibleAuctions(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->andWhere('a.dateOpen <= :now')
            ->setParameter('status', 'STANDBY')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function findTerminatingAuctions(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->andWhere('a.dateClose <= :now')
            ->setParameter('status', 'VISIBLE')
            ->setParameter('now', (new \DateTime()))
            ->getQuery()
            ->getResult();
    }

    public function findArchivingAuctions(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->andWhere('a.dateClose <= :threeMonthsAgo')
            ->setParameter('status', 'TERMINATED')
            ->setParameter('threeMonthsAgo', (new \DateTime())->modify('-3 months'))
            ->getQuery()
            ->getResult();
    }


    public function save(Auction $auction): void
    {
        $this->_em->persist($auction);
        $this->_em->flush();
    }
//    /**
//     * @return Auction[] Returns an array of Auction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Auction
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
