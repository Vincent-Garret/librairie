<?php


namespace App\Controller;

// je fais un "use" vers le namespace (qui correspond au chemin) de la classe "Route"
// ça correspond à un import ou un require en PHP
// pour pouvoir utiliser cette classe dans mon code
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
     */
    public function books(AuthorRepository $authorRepository)
    {

        // récupérer le repository des Books, car c'est la classe Repository
        // qui me permet de sélectionner les livres en bdd
        $authors = $authorRepository->findAll();

        return $this->render('authors.html.twig', [
            'authors' => $authors
        ]);

    }
    //je fais une nouvelle route avec une wild card
    /**
     * @route("/author/show/{id}", name="author")
     */
    public function author(AuthorRepository $authorRepository, $id)
    {
        //je viens récuperer mes données exactement comme precedement
        $authors = $authorRepository->find($id);

        return $this->render('author.html.twig', [
            'authors' => $authors
        ]);
    }
    /**
     * @route("/author/insert", name="author_insert")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function insertBook(EntityManagerInterface $entityManager, Request $request)
    {
        //inserer un livre en BDD
        //je fais un nouvel auteur en créant un enregistrement
        $author = new Author();
        $name = $request->query->get( 'name');
        $firstName = $request->query->get( 'firstName');
        $birthDate = $request->query->get('birthDate');
        $deathDate = $request->query->get('deathDate');
        $biography = $request->query->get('biography');
        //je set mes parametres de l'auteur en utilisant les seteur de mon entité
        $author->setName($name);
        $author->setFirstName($firstName);
        $author->setBirthDate($birthDate);
        $author->setDeathDate($deathDate);
        $author->setBiography($biography);

        //j'utilise entitymanager pour sauvegarder mon entité
        $entityManager->persist($author);
        $entityManager->flush();
        return new Response('auteur enregistré');
    }
    /**
     * @route("/author/delete/{id}", name="author_delete")
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     */
    public function deleteAuthor(AuthorRepository $authorRepository, EntityManagerInterface $entityManager, $id)
    {
        //jefface un auteur
        //je reupere un element qui sera une entite
        //et je stock dans une variable
        $author = $authorRepository->find($id);

        $entityManager->remove($author);

        $entityManager->flush();

        return new Response('auteur supprimé');
    }
    /**
     * @route("author/update/{id}", name="author_update")
     */
    public function updateAuthor(AuthorRepository $authorRepository, $id, EntityManagerInterface $entityManager)
    {
        //recuperer un l'auteur en bdd
        $author = $authorRepository->find($id);
        //avec l'entite recupéré on utilise les setteur pour modifier les champs souhaiter
        $author->setName('nom modifié');

        //on reenregistre l'auteur
        $entityManager->persist($author);
        $entityManager->flush();

        return new Response('l\'auteur a bien été modifié');
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

        return $this->render('search.author.html.twig', [
            'authors' => $authors,
            'search' => $search

        ]);
    }

}