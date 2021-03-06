<?php


namespace App\Controller\admin;

// je fais un "use" vers le namespace (qui correspond au chemin) de la classe "Route"
// ça correspond à un import ou un require en PHP
// pour pouvoir utiliser cette classe dans mon code
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

// je créé ma classe BookController et je la nomme de la même manière que mon fichier
class BookController extends AbstractController
{

    /**
     * @Route("/admin/books", name="admin_books")
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

        return $this->render('admin/books.html.twig', [
            'books' => $books
        ]);

    }
    //je fais une nouvelle route avec une wild card
    /**
     * @route("/admin/book/show/{id}", name="admin_book")
     */
    public function book(BookRepository $bookRepository, $id)
    {
        //je viens récuperer mes données exactement comme precedement
        $books = $bookRepository->find($id);

            return $this->render('admin/book.html.twig', [
                'books' => $books
        ]);
    }

    /**
     * @route("/admin/book/insert", name="admin_book_insert")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function insertBook(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        //je crée un nouveau livre pour le lier a mon formulaire
        $book = new Book();

        //je crée un formulaire qui est relié a mon nouveau livre
        $formBook = $this->createForm(BookType::class, $book);

        $formBook->handleRequest($request);
        //je demande a mon formulaire $formBook de gerer les données
        //de ma requete post
        if($formBook->isSubmitted() && $formBook->isValid()){
            /** @var UploadedFile $coverFile */
            $coverFile = $formBook->get('cover')->getData();
                if($coverFile){
                    $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$coverFile->guessExtension();
                    $coverFile = $formBook->get('cover')->getData();
                    $coverFile->move(
                        $this->getParameter('cover_directory'),
                        $newFilename
                        );
                        $book->setCover($newFilename);
                }
            //je persist le book
            $entityManager->persist($book);
            $entityManager->flush();

            //message flash
            $this->addFlash('success', 'votre livre a été enregistré');

            return $this->redirect($this->generateUrl('admin_books'));
        }

        return $this->render('admin/insert.html.twig', [
            'formBook' => $formBook->createView()
        ]);
    }

    /**
     * @route("admin/book/delete/{id}", name="admin_book_delete")
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
        //message flash
        $this->addFlash('success', 'votre livre a été enregistré');

        return new Response('livre supprimé');

    }
    /**
     * @route("admin/book/update/{id}", name="admin_book_update")
     */
    public function updateBook(BookRepository $bookRepository, $id, EntityManagerInterface $entityManager, Request $request)
    {
        //recuperer un livre en bdd
        $book = $bookRepository->find($id);
        //je crée un formulaire qui est relié a mon nouveau livre
        $formBook = $this->createForm(BookType::class, $book);

        $formBook->handleRequest($request);
        //je demande a mon formulaire $formBook de gerer les données
        //de ma requete post
        if($formBook->isSubmitted() && $formBook->isValid()){
            //je persist le book
            $entityManager->persist($book);
            $entityManager->flush();

            //message flash
            $this->addFlash('success', 'votre livre a été updaté');
        }

        return $this->render('admin/insert.html.twig', [
            'formBook' => $formBook->createView()
        ]);

    }

    /**
     * @route("/admin/book/search", name="admin_book_search")
     */
    public  function searchByResume(BookRepository $bookRepository, Request $request)
    {
        $search = $request->get('search');

        $books = $bookRepository->getByWordInResume($search);

        return $this->render('admin/search.html.twig', [
            'books' => $books,
            'search' => $search

        ]);
    }

}