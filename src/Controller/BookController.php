<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BookController extends AbstractController
{
    /**
     * @param BookRepository $bookRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/book/list", name="book_list")
     *
     * Je passe en parametre la classe "EntityManagerInterface" avec la variable
     * $entityManager, pour que Symfony mette dans la variable une instance de la
     * classe
     */
    public function bookList(BookRepository $bookRepository)
    {
        // j'utilise l'instance de la classe entity Manager, pour récupérer
        // le répository des Book.
        // j'ai besoin du repository pour faire des requetes SELECT dans la table
        //($bookRepository = $entityManager->getRepository(Book::class);)
        // j'utilise la méthode findAll du repository pour récupérer tous mes Books

        return $this->render('book.html.twig',[
            'books' => $bookRepository->findAll()
        ]);

    }

    /**
     * @param BookRepository $bookRepository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/book/show/{id}", name="book_show")
     */
    public function bookShow(BookRepository $bookRepository, $id)
    {
        // j'utilise la méthode find du BookRepository afin
        // de récupérer un livre dans la table Book en fonction
        // de son id
        //$books = $bookRepository->find($id);
        return $this->render('onebook.html.twig',[
            'book'=> $bookRepository->find($id)
        ]);
    }

    /**
     * @param BookRepository $bookRepository
     * @Route("/bookgenre" ,name="book_genre")
     */
    public function bookByGenre(BookRepository $bookRepository)
    {
        $books = $bookRepository->findByGenre();
        dump($books);die;
    }
}
