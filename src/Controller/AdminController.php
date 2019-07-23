<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    ///**
     //* @Route("/admin/book/insert", name="book_insert")
     //* Je met en parametre de la méthode l'entity Manager
     //* car c'est l'outil qui me permet de gérer mes entités
     //*/

/*    public function insertBook(EntityManagerInterface $entityManager, AuthorRepository $authorRepository)
    {
        //je recupere un auteur en fonction de son id
        $author = $authorRepository->find(1);

        //je crée une nouvelle instance de l'entité book
        //c'est cette entité qui est le miroir de la table book
        $book = new Book();

        //je set toutes les infos de mon livres grâce aux setters
        //crées dans l'entity
        $book->setTitre('titre test');
        $book->setNombreDePages(1234);
        $book->setResume('resumé de mon livre test');
        $book->setGenre('thriller');

        // j'utlise le setter d'auteur (dans l'entite book) pour
        //reliér un auteur à mon livre
        $book->setAuthor($author);


        //j'enregistre mon livre en bdd
        //avec les méthodes persist() et flush()
        $entityManager->persist($book);
        $entityManager->flush();

        dump('livre enregistré');
        die;
    }*/

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/admin.html.twig');
    }

    /**
     * @Route("/admin/book/{id}/delete", name="admin_book_delete")
     *
     * Je récupère la valeur de la wildcard {id} dans la variable id
     * Je récupère le bookRepository car j'ai besoin d'utiliser la méthode find
     * Je récupère l'entityManager car c'est lui qui me permet de gérer les entités (ajout, suppression, modif)
     */
    public function deleteBook($id, BookRepository $bookRepository, EntityManagerInterface $entityManager)
    {
        // je récupère le livre dans la BDD qui a l'id qui correspond à la wildcard
        // ps : c'est une entité qui est récupérée
        $book = $bookRepository->find($id);


        // j'utilise la méthode remove() de l'entityManager en spécifiant
        // le livre à supprimer
        $entityManager->remove($book);
        $entityManager->flush();

        var_dump("livre supprimé");
        die;
    }

    /**
     * @Route("/admin/book/{id}/update", name="admin_book_update")
     *
     * Je récupère la valeur de la wildcard {id} dans la variable id
     * Je récupère le bookRepository car j'ai besoin d'utiliser la méthode find
     * Je récupère l'entityManager car c'est lui qui me permet de gérer les entités (ajout, suppression, modif)
     */
    public function updateBook($id, BookRepository $bookRepository, EntityManagerInterface $entityManager, authorRepository $authorRepository, Request $request)
    {
        // je récupère ;le livre dans la BDD qui a l'id qui correspond à la wildcard
        $book = $bookRepository->find($id);

        $form = $this->createForm(BookType::class, $book);

        $formView = $form->createView();

        if ($request->isMethod('Post')) {

            //le formulaire récupère les infos de la requête
            $form->handleRequest($request);

            //on enregistre l'entite créer avec persit et flush
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book_list');
        }

        // j'utilise le setter du titre pour modifier le titre du livre
        //$book->setAuthor($author);

        // je re-enregistre le livre dans la base de données
        //$entityManager->persist($book);
        //$entityManager->flush();


        return $this->render('book/bookforminsert.html.twig', [
            'formBookView' => $formView
        ]);
    }

    /**
     * @Route("/admin/form_book_create", name="form_book_create")
     * je mets en parametre de la méthode l'entity manager car c'est l'outil qui me permet de gérer mes entités
     */
    public function createBook(Request $request, EntityManagerInterface $entityManager, bookRepository $bookRepository, AuthorRepository $authorRepository)
    {
        //je créé une nouvelle instance de l'entité Book
        //c'est cette entité qui est le miroir de la table Book
        $book = new Book();

        //je mets toutes les infos de mon livre grâce aux setters
        //créés dans l'entité
        /*$book->setTitre('Livre Test1');
        $book->setNombreDePages('1234');
        $book->setResume('Résumé de mon nouveau livre');
        $book->setGenre('Biopic');*/

        $form = $this->createForm(BookType::class, $book);

        //création de la view du formulaire
        $formBookView = $form->createView();

        //Si la méthode est POST, si le formulaire est envoyé
        if ($request->isMethod('Post')) {

            //Le formulaire récupère les infos de la requête
            $form->handleRequest($request);

            if ($form->isValid()) {

                $entityManager->persist($book);
                $entityManager->flush();
            }
        }

        return $this->render('book/bookforminsert.html.twig',
            [
                'formBookView' => $formBookView
            ]
        );

    }

    /**
     * @Route("/admin/book/form_insert", name="book_form_insert")
     */
    public function bookFormInsert(Request $request, EntityManagerInterface $entityManager)
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);

        $formBookView = $form->createView();

        if ($request->isMethod('Post')) {

            //le formulaire récupère les infos de la requête
            $form->handleRequest($request);

            //on enregistre l'entite créer avec persit et flush
            $entityManager->persist($book);
            $entityManager->flush();
        }

        return $this->render('book/bookforminsert.html.twig', [
            'formBookView' => $formBookView
        ]);
    }
    /**
     * @Route("/author/insert", name="author_insert")
     *
     * Je met en parametre de la méthode l'entity Manager
     * car c'est l'outil qui me permet de gérer mes entités
     */

    public function insertAuthor(EntityManagerInterface $entityManager, Request $request)
    {
        //je crée une nouvelle instance de l'entité book
        //c'est cette entité qui est le miroir de la table book
        $author = new Author();

        //je set toutes les infos de mon livres grâce aux setters
        //crées dans l'entity
       /* $author->setLastName('nom');
        $author->setFirstName('prenom');
        $author->setBio('biographie');
        $author->setBirthDate(new \DateTime('1628-01-12'));

        //j'enregistre mon livre en bdd
        //avec les méthodes persist() et flush()
        $entityManager->persist($author);
        $entityManager->flush();




        );*/

        $form = $this->createForm(AuthorType::class, $author);

        //création de la view du formulaire
        $formAuthorView = $form->createView();

        //Si la méthode est POST, si le formulaire est envoyé
        if ($request->isMethod('Post')) {

            //Le formulaire récupère les infos de la requête
            $form->handleRequest($request);

            if ($form->isValid()) {

                $entityManager->persist($author);
                $entityManager->flush();
            }
        }
        return $this->render('auteur/authorforminsert.html.twig',
            [
                'formAuthorView' => $formAuthorView
            ]);
    }
    /**
     * @Route("/author/{id}/delete", name="author_delete")
     */
    public function deleteAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager)
    {
        $author = $authorRepository->find($id);

        $entityManager->remove($author);
        $entityManager->flush();

        var_dump('auteur supprimé'); die;
    }
    /**
     * @Route("/author/{id}/update", name="author_update")
     */
    public function updateAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager, Request $request)
    {
        $author = $authorRepository->find($id);

        $form = $this->createForm(AuthorType::class, $author);

        $formView = $form->createView();

        if ($request->isMethod('Post')) {

            //le formulaire récupère les infos de la requête
            $form->handleRequest($request);

            //on enregistre l'entite créer avec persit et flush
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('authors_list');
        }

        // j'utilise le setter du titre pour modifier le titre du livre
        //$book->setAuthor($author);

        // je re-enregistre le livre dans la base de données
        //$entityManager->persist($book);
        //$entityManager->flush();


        return $this->render('auteur/authorforminsert.html.twig', [
            'formAuthorView' => $formView
        ]);

    }

    /**
     * @Route("/authors/form_insert", name="authors_form_insert")
     */
    public function authorFormInsert(Request $request, EntityManagerInterface $entityManager ){

        $author = new Author();

        //utilisation dun fichier AuthorType pour créer un form
        //(ne contient pas encore de html)
        $form = $this->createForm(AuthorType::class, $author );

        //creation de la view du formulaire
        $formAuthorView = $form->createView();

        // si la méthode est post
        //si le form est envoyé
        if ($request->isMethod('Post')) {

            //le formulaire récupère les infos de la requête
            $form->handleRequest($request);

            //on enregistre l'entite créer avec persit et flush
            $entityManager->persist($author);
            $entityManager->flush();
        }


        //envoie de la view du form au fichier twig
        return $this->render('auteur/authorFormInsert.html.twig',[
            'formAuthorView' => $formAuthorView
        ]);
    }

    /**
     * @Route("/authors_form_create/{id}", name="authors_form_create")
     */
    public function createFormAuthor(Request $request,EntityManagerInterface $entityManager,$id, AuthorRepository $authorRepository)
    {

        $author = $authorRepository->find($id);

        //utilisation dun fichier AuthorType pour créer un form
        //(ne contient pas encore de html)
        $form = $this->createForm(AuthorType::class, $author);

        //creation de la view du formulaire
        $formAuthorView = $form->createView();

        // si la méthode est post
        //si le form est envoyé
        if ($request->isMethod('Post')) {

            //le formulaire récupère les infos de la requête
            $form->handleRequest($request);

            //on vérifie que le formulaire est valide
            if ($form->isValid()) {
                //on enregistre l'entite créer avec persit et flush
                $entityManager->persist($author);
                $entityManager->flush();
            }

        }



        //envoie de la view du form au fichier twig
        return $this->render('auteur/authorFormInsert.html.twig',[
            'formAuthorView' => $formAuthorView
        ]);
    }


}
