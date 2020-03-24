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

// je créé ma classe BoucleController et je la nomme de la même manière que mon fichier
class BoucleController extends AbstractController
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
     */
    public function insertBook(EntityManagerInterface $entityManager)
    {
        //inserer un livre en BDD
        //je fais un nouveau livre en créant un enregistrement
        $book = new Book();

        //je set mes parametres du livre en utilisant les seteur de mon entité
        $book->setTitle('Remi');
        $book->setAuthor('David');
        $book->setNbPages(1);
        $book->setResume('Comment Remi triche pour finir plus vite');

        //j'utilise entitymanager pour sauvegarder mon entité
        $entityManager->persist($book);
        $entityManager->flush();
        return new Response('livre enregistré');
    }


}