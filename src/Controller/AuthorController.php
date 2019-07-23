<?php


namespace App\Controller;


use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/authors/list", name="authors_list")
     */
   public function authorsList(AuthorRepository $authorRepository){

       return $this->render('auteur/authorsList.html.twig',[
           'authors' => $authorRepository->findAll()
       ]);

   }

    /**
     * @Route("/author/show/{id}", name="author_show")
     */
    public function authorShow(AuthorRepository $authorRepository, $id){
       return $this->render('auteur/authorShow.html.twig',[
           'author'=> $authorRepository->find($id)
       ]);
   }

    /**
     * @Route("/author/bio", name="authors_bio")
     */
   public function authorsByBiography(AuthorRepository $authorRepository, Request $request){

       $word = $request->query->get('word'); // ou passée en wildcard dans l'url
       $authors = $authorRepository->getAuthorsByBio($word);

       return $this->render('auteur/authorsList.html.twig', [
           'authors' => $authors
       ]);
   }
    }