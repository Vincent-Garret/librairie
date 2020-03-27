<?php


namespace App\Controller\front;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;

class HomeController extends AbstractController
{
    /**
     * @route("/home", name="home")
     * @param BookRepository $bookRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(BookRepository $bookRepository)
    {
        // récupérer le repository des Books, car c'est la classe Repository
        // qui me permet de sélectionner les livres en bdd
        $books = $bookRepository->findAll();

        return $this->render('front/books.html.twig', [
            'books' => $books
        ]);

    }
    /**
     * @route("/book/search", name="book_search")
     */
    public  function searchByResume(BookRepository $bookRepository, Request $request)
    {
        $search = $request->get('search');

        $books = $bookRepository->getByWordInResume($search);

        return $this->render('front/search.html.twig', [
            'books' => $books,
            'search' => $search

        ]);
    }
    //je fais une nouvelle route avec une wild card
    /**
     * @route("/book/show/{id}", name="book")
     */
    public function book(BookRepository $bookRepository, $id)
    {
        //je viens récuperer mes données exactement comme precedement
        $books = $bookRepository->find($id);

        return $this->render('front/book.html.twig', [
            'books' => $books
        ]);
    }
}