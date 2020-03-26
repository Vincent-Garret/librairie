<?php


namespace App\Controller\front;


use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/authors", name="authors")
     *
     * on utilise l'"autowire" de Symfony pour demander à Symfony
     * d'instancier la classe BookRepository dans la variable $bookRepository.
     * Ca marche pour toutes les classes de Symfony (sauf les entités)
     * @param AuthorRepository $authorRepository
     * @return Response
     */
    public function authors(AuthorRepository $authorRepository)
    {
        // récupérer le repository des Books, car c'est la classe Repository
        // qui me permet de sélectionner les livres en bdd
        $authors = $authorRepository->findAll();

        return $this->render('front/authors.html.twig', [
            'authors' => $authors
        ]);
    }
    //je fais une nouvelle route avec une wild card
    /**
     * @route("author/show/{id}", name="author")
     */
    public function author(AuthorRepository $authorRepository, $id)
    {
        //je viens récuperer mes données exactement comme precedement
        $authors = $authorRepository->find($id);

        return $this->render('front/author.html.twig', [
            'authors' => $authors
        ]);
    }
    /**
     * @route("/author/search", name="author_search")
     * @param AuthorRepository $authorRepository
     * @param Request $request
     * @return Response
     */
    public  function searchByAuthor(AuthorRepository $authorRepository, Request $request)
    {
        $search = $request->get('search');

        $authors = $authorRepository->getByWordInBiography($search);

        return $this->render('front/search.author.html.twig', [
            'authors' => $authors,
            'search' => $search

        ]);
    }
}