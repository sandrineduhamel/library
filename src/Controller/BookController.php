<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class BookController extends AbstractController
{
    /**
     * @Route("/book/list", name="book_list")
     *
     * Je passe en parametre la classe "EntityManagerInterface" avec la variable
     * $entityManager, pour que Symfony mette dans la variable une instance de la
     * classe
     */
    public function bookList(BookRepository $bookRepository, AuthorRepository $authorRepository)
    {
        // j'utilise l'instance de la classe entity Manager, pour récupérer
        // le répository des Book.
        // j'ai besoin du repository pour faire des requetes SELECT dans la table
        //($bookRepository = $entityManager->getRepository(Book::class);)
        // j'utilise la méthode findAll du repository pour récupérer tous mes Books
        $authors = $authorRepository->findAll();
        $books = $bookRepository->findAll();

        return $this->render('book/book.html.twig',
            [
                'authors' => $authors,
                'books' => $books
            ]
        );

    }

    /**
     * @Route("/book/show/{id}", name="book_show")
     */
    public function bookShow(BookRepository $bookRepository, $id)
    {
        // j'utilise la méthode find du BookRepository afin
        // de récupérer un livre dans la table Book en fonction
        // de son id
        //$books = $bookRepository->find($id);
        $books = $bookRepository->find($id);
        return $this->render('book/onebook.html.twig',
            [
                'book' => $books
            ]
        );
    }

    /**
     * @Route("/book/search", name="book_search")
     */
    public function booksSearch(BookRepository $bookRepository, Request $request)
    {
        $author = $request->query->get('author');
        $search = $request->query->get('titre');

        $books = $bookRepository->getSearchAuthor($search, $author);

        return $this->render('book/book.html.twig',
            [
                'books' => $books
            ]
        );
    }

    /**
     * @param BookRepository $bookRepository
     * @Route("/bookgenre" ,name="book_genre")
     */
    public function bookByGenre(BookRepository $bookRepository)
    {
        $books = $bookRepository->findByGenre();
        dump($books);
        die;
    }


}