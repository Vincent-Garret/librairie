<?php


namespace App\Controller\admin;

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
     */
    public function adminDashboard()
    {
        return $this->render('admin/dashboard.html.twig');
    }

}