<?php

namespace App\Repository;

use App\Entity\Upvote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Upvote>
 */
class UpvoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Upvote::class);
    }

    public function countUpvotesForFeedback($feedbackId)
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.feedback = :feedbackId')
            ->setParameter('feedbackId', $feedbackId)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    //    /**
    //     * @return Upvote[] Returns an array of Upvote objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Upvote
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
