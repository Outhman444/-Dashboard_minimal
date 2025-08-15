<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_categories')]
    public function index(): Response
    {   
        return $this->render('category/index.html.twig', [
            'Category' => ' salut Category',
        ]);
    }
}
