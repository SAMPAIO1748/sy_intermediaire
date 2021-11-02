<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // Fonction qui va chercher dans la table product et category de la base de données
    public function searchByTerm($term)
    {
        // QuerBulder permet de créer des requêtes SQL en PHP
        $queryBuilder = $this->createQueryBuilder('product');

        // Requête SQL
        $query = $queryBuilder
            ->select('product') // SELECT
            ->leftJoin('product.category', 'category') // LEFT join sur la table category
            ->where('product.name LIKE :term') // WHERE
            ->orWhere('product.description LIKE :term') // WHERE
            ->orWHere('category.name LIKE :term')
            ->orWhere('category.description LIKE :term')
            ->setParameter('term', '%' . $term . '%') // Sécuriser le term et lui attribuer une valeur
            ->getQuery(); // Retourne la requête

        return $query->getResult(); // Retourne le tableau des résultat
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
