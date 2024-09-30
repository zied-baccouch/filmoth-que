<?php

// src/Repository/FilmRepository.php

namespace App\Repository;

use App\Entity\Film;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Film>
 *
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }
    
    public function findBySearchData(SearchData $searchData): array
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->leftJoin('f.acteurFilm', 'af')
            ->leftJoin('af.id_acteur', 'a')
            ->leftJoin('f.categorie', 'c')
            ->addSelect('af', 'a', 'c');
    
        if ($searchData->getTitre()) {
            $queryBuilder->andWhere('f.titre LIKE :titre')
                ->setParameter('titre', '%' . $searchData->getTitre() . '%');
        }
    
        if ($searchData->getActeur()) {
            $queryBuilder->andWhere('a.nom LIKE :acteur OR a.prenom LIKE :acteur')
                ->setParameter('acteur', '%' . $searchData->getActeur() . '%');
        }
    
        
    
        if ($searchData->getCategorie()) {
            $queryBuilder->andWhere('c.design_categorie LIKE :categorie')
                ->setParameter('categorie', '%' . $searchData->getCategorie() . '%');
        }
        
    
        return $queryBuilder->getQuery()->getResult();
    }
    public function countFilmsByCategory(): array
    {
        return $this->createQueryBuilder('f')
            ->select('c.design_categorie, COUNT(f.id) as film_count')
            ->leftJoin('f.categorie', 'c')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();
    }
}