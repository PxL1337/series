<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 *
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function save(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Serie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBestSeries($offset = 0) {
        //en DQL
        $entityManager = $this->getEntityManager();
        /*$dql = "
            SELECT s
            FROM App\Entity\Serie s
            WHERE s.popularity > 100
            AND s.vote > 8
            ORDER BY s.popularity DESC
        ";
        $query = $entityManager->createQuery($dql);
        $query->setMaxResults(50);
        $results = $query->getResult();*/


        //version QueryBuilder
        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder->leftJoin('s.seasons', 'seasons')
            ->addSelect('seasons');

        //$queryBuilder->andWhere('s.popularity > 50');
        //$queryBuilder->andWhere('s.vote > 8');
        $queryBuilder->orderBy('s.popularity', 'DESC');
        $queryBuilder->setFirstResult($offset);
        $query = $queryBuilder->getQuery();
        $query->setMaxResults(50);

        $paginator = new Paginator($query);

        return $paginator;
    }

//    /**
//     * @return Serie[] Returns an array of Serie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Serie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
