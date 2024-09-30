<?php

namespace App\Repository;

use App\Entity\ActeurFilm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActeurFilm>
 *
 * @method ActeurFilm|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActeurFilm|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActeurFilm[]    findAll()
 * @method ActeurFilm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActeurFilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActeurFilm::class);
    }

    //    /**
    //     * @return ActeurFilm[] Returns an array of ActeurFilm objects
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

    //    public function findOneBySomeField($value): ?ActeurFilm
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
