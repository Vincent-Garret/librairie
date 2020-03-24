<?php


namespace App\Controller;

// je fais un "use" vers le namespace (qui correspond au chemin) de la classe "Route"
// ça correspond à un import ou un require en PHP
// pour pouvoir utiliser cette classe dans mon code
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// je créé ma classe BookController et je la nomme de la même manière que mon fichier
class BookController extends AbstractController
{

    /**
     * @Route("/books", name="books")
     *
     * on utilise l'"autowire" de Symfony pour demander à Symfony
     * d'instancier la classe BookRepository dans la variable $bookRepository.
     * Ca marche pour toutes les classes de Symfony (sauf les entités)
     */
    public function books(BookRepository $bookRepository)
    {

        // récupérer le repository des Books, car c'est la classe Repository
        // qui me permet de sélectionner les livres en bdd
        $books = $bookRepository->findAll();

        return $this->render('books.html.twig', [
            'books' => $books
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

            return $this->render('book.html.twig', [
                'books' => $books
        ]);
    }

    /**
     * @route("/book/insert", name="book_insert")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function insertBook(EntityManagerInterface $entityManager, Request $request)
    {
        //inserer un livre en BDD
        //je fais un nouveau livre en créant un enregistrement
        $book = new Book();
        $title = $request->query->get( 'title');
        $author = $request->query->get( 'author');
        $nbPages = $request->query->get('nbPages');
        $resume = $request->query->get('resume');
        //je set mes parametres du livre en utilisant les seteur de mon entité
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setNbPages($nbPages);
        $book->setResume($resume);

        //j'utilise entitymanager pour sauvegarder mon entité
        $entityManager->persist($book);
        $entityManager->flush();
        return new Response('livre enregistré');
    }

    /**
     * @route("/book/delete/{id}", name="book_delete")
     * @param BookRepository $bookRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return Response
     */
    public function deleteBook(BookRepository $bookRepository, EntityManagerInterface $entityManager, $id)
    {
        //jefface un book
        //je reupere un element qui sera une entite
        //et je stock dans une variable
        $book = $bookRepository->find($id);

        $entityManager->remove($book);

        $entityManager->flush();

        return new Response('livre supprimé');
    }
    /**
     * @route("book/update/{id}", name="book_update")
     */
    public function updateBook(BookRepository $bookRepository, $id, EntityManagerInterface $entityManager)
    {
        //recuperer un livre en bdd
        $book = $bookRepository->find($id);
        //avec l'entite recupéré on utilise les setteur pour modifier les champs souhaiter
        $book->setTitle('titre modifié');

        //on reenregistre le livre
        $entityManager->persist($book);
        $entityManager->flush();

        return new Response('le livre a bien été modifié');
    }

    /**
     * @route("/book/search", name="book_search")
     */
    public  function searchByResume(BookRepository $bookRepository)
    {
        $books = $bookRepository->getByWordInResume();

        return $this->render('books.html.twig', [
            'books' => $books
        ]); 
    }

}