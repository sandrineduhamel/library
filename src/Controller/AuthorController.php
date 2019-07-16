<?php


namespace App\Controller;


use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @param AuthorRepository $authorRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/author/list",name="author_list")
     */
   public function authorList(AuthorRepository $authorRepository){

       return $this->render('auteur.html.twig',[
           'authors' => $authorRepository->findAll()
       ]);

   }

    /**
     * @param AuthorRepository $authorRepository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/author/show/{id}", name="author_show")
     */
   public function authorShow(AuthorRepository $authorRepository, $id){
       return $this->render('auteur.html.twig',[
           'authors'=> $authorRepository->find($id)
       ]);
   }

    /**
     * @Route("/author/bio/{word}", name="authors_bio")
     */
   public function authorsByBiography(AuthorRepository $authorRepository, $word){
       $authors= $authorRepository->getAuthorsByBio($word);

       return $this->render('auteur.html.twig', [
           'authors' => $authors
       ]);
   }
}