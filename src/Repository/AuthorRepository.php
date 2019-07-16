<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Author::class);
    }


    //méthode pour trouver des auteurs en fonction d'un mot de leur biographie

    //créer la méthode  qui fait la requête SQL
    //créer la route (dans la classe de controlleur)
    //créer la méthode de controlleur liée à la route
    //appeler la méthode du repository (celle qui fait la requete sql)
    //enregistrer les resultats de la requete SQL dans une variable
    //afficher la variable

    public function getAuthorsByBio($word)
    {
        //$word = 'Wilhelm';
        //je recupere le query builder qui me permet de créer des
        //requetes SQL
        $qd = $this-> createQueryBuilder('a');
        //je selectionne tous les auteurs de la bdd

        $query = $qd->select('a')

            //si le word est trouv"-é dans la bio
            ->where('a.bio LIKE :word')

            //j'utilise le setParameter pour securiser la requete
            ->setParameter('word','%'.$word.'%')
            //je cree la requete SQL
            ->getQuery();

        //je récupère les résultats sous forme d'array
        $resultats = $query->getArrayResult();

        return $resultats;

    }
}
