<?php


namespace App\Controller\admin;

// je fais un "use" vers le namespace (qui correspond au chemin) de la classe "Route"
// ça correspond à un import ou un require en PHP
// pour pouvoir utiliser cette classe dans mon code
use App\Entity\Author;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AuthorController extends AbstractController
{
    /**
     * @Route("/admin/authors", name="admin_authors")
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

        return $this->render('admin/authors.html.twig', [
            'authors' => $authors
        ]);

    }
    //je fais une nouvelle route avec une wild card
    /**
     * @route("/admin/author/show/{id}", name="admin_author")
     */
    public function author(AuthorRepository $authorRepository, $id)
    {
        //je viens récuperer mes données exactement comme precedement
        $authors = $authorRepository->find($id);

        return $this->render('admin/author.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
     * @route("/admin/author/insert", name="admin_author_insert")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function insertBook(EntityManagerInterface $entityManager, Request $request)
    {
        //je declare la variable qui contient mon nouvel auteur
        $author = new Author();

        //je crée mon formulaire et je le lie avec le nouvel auteur et le BookType
        $formAuthor = $this->createForm(AuthorType::class,$author);
        //je sais plus trop
        $formAuthor->handleRequest($request);
        //je demande a mon formulaire $formAuthor de gerer les données
        //de ma requete post
        if($formAuthor->isSubmitted() && $formAuthor->isValid()){
            //je persist et flush
            //un peu comme commit et push
            $entityManager->persist($author);
            $entityManager->flush();
        }
        //je retourne sur ma page twig a laquelle je lie mon render
        return $this->render('admin/insertAuthor.html.twig',[
            'formAuthor' =>$formAuthor->createView()
        ]);
    }
    /**
     * @route("/admin/author/delete/{id}", name="admin_author_delete")
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
     * @route("/admin/author/update/{id}", name="admin_author_update")
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
     * @route("/admin/author/search", name="admin_author_search")
     * @param AuthorRepository $authorRepository
     * @param Request $request
     * @return Response
     */
    public  function searchByAuthor(AuthorRepository $authorRepository, Request $request)
    {
        $search = $request->get('search');

        $authors = $authorRepository->getByWordInBiography($search);

        return $this->render('admin/search.author.html.twig', [
            'authors' => $authors,
            'search' => $search

        ]);

    }

}