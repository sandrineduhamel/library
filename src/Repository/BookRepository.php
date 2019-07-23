<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function getBooks($search)
    {
        // LIGNE A MODIFIER, VALEUR A RECUPERER DEPUIS L'URL (DONC A TRAITER DANS LE CONTROLEUR)
        // je récupère le query builder, qui me permet de créer des
        // requetes SQL
        $qb = $this->createQueryBuilder('b');
        // je sélectionne tous les livres de la base de données
        $query = $qb->select('b')
            // si le 'word' est trouvé dans le titre
            ->where('b.titre LIKE :search')
            // j'utilise le setParameter pour sécuriser la requete
            ->setParameter('search', '%'.$search.'%')
            // je créé la requete SQL
            ->getQuery();
        // je récupère les résultats sous forme d'array
        $result = $query->getArrayResult();

        return $result;
    }

    public function getSearchAuthor($search = null, $author = null)
    {
        $qb = $this->createQueryBuilder('b');

        $qb->select('b');

        if(!empty($author)) {
            $qb->andWhere('b.author = :id')
            ->setParameter('id', $author);
        }

        if(!empty($search)) {
            $qb->andWhere('b.titre LIKE :search')
            ->setParameter('search', '%'.$search.'%');
        }

        $query = $qb->getQuery();
        $result = $query->getArrayResult();

        return $result;
    }






    /**
     * Je créée une nouvelle requête en bdd, pour
     * recupérer tous les livres en foncction
     *
     * (requête test, car le méthode existe déjà dans le repo)
     */
    public function findByGenre()
    {
        $genre='fantastique';

        //je récupere le query builder de doctrine pour créer la requête
        $qb = $this->createQueryBuilder('b');

        //je viens sélectionner tous les éléments
        //de la table book
        $query = $qb->select('b')

                //je fais ma condition WHERE
                //je lui demande de récupérer uniquement
                //les livres dont la colonne style
                //correspond à la valeur de la variable $style
            ->where('b.genre = :genre')

            //j'utilise les paramètres pour sécuriser la variable
            //$style et évité les attaques
            ->setParameter('genre', $genre)
            //je créée la requête SQL équivalente
            ->getQuery();

        //je récupère les résultats sous forme d'array
        $resultats = $query->getArrayResult();
        return $resultats;
    }



    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
