<?php


namespace App\Controller\admin;

use App\Repository\AuthorRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    /**
     * @route("/admin", name="admin_dashboard")
     * @param BookRepository $bookRepository
     * @param AuthorRepository $authorRepository
     * @return Response
     */
    public function adminDashboard(BookRepository $bookRepository,
                                   AuthorRepository $authorRepository)
    {

        $authors = $authorRepository;
        $books = $bookRepository->findAll();
        //$lastAuthors = $authorRepository->findBy(array(), ['id'=>'DESC'], 2);
        //$lastBooks = $bookRepository->findBy(array(), ['id'=>'DESC'], 2);
        return $this->render('admin/dashboard.html.twig', [
            'books' => $books,
            'authors' => $authors
        ]);
    }

}