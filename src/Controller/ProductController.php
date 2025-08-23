<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Knp\Component\Pager\PaginatorInterface;


final class ProductController extends AbstractController

{
   
#[Route('/products/{page}', name: 'app_products', requirements: ['page' => '\\d+'], defaults: ['page' => 1])]
    public function index(int $page, ProductRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {


        #hna tartib prduit mn akbar id 
        $queryBuilder = $repo->createListQueryBuilder();

        $pagination = $paginator->paginate(
            $queryBuilder, 
            $page,        
            5         
        );

        return $this->render('product/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }












#[Route('/product/new', name: 'product_new', methods: ['GET', 'POST'])]
public function newProduct(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
{
    if ($request->isMethod('GET')) {
        return $this->render('product/new.html.twig', [
            'oldData' => [],
            'errors' => [],
        ]);
    }

    $product = new Product();
    $product->setNom($request->request->get('nom'));
    $product->setPrix((float) $request->request->get('prix'));
    $product->setQuantite($request->request->get('quantite'));
    $product->setDescription($request->request->get('description'));
    $product->setStatus($request->request->get('status') == '1');

    $errors = $validator->validate($product);

    if (count($errors) > 0) {
        $errorMessages = [];
        foreach ($errors as $error) {
            $field = $error->getPropertyPath();
            $errorMessages[$field][] = $error->getMessage();
        }

        return $this->render('product/new.html.twig', [
            'errors' => $errorMessages,
            'oldData' => $request->request->all(),
        ]);
    }

    $em->persist($product);
    $em->flush();

    $this->addFlash('success', 'Produit "' . $product->getNom() . '" ajouté avec succès.');

    return $this->redirectToRoute('app_products');
}









 #[Route('/product/{id}', name: 'product_edit', methods: ['GET', 'POST'])]
    public function editProduct(int $id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $product = $em->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Produit introuvable');
        }

        if ($request->isMethod('GET')) {
            return $this->render('product/edit.html.twig', ['product' => $product]);
        }

        $product->setNom($request->request->get('nom'));
    $product->setPrix((float) $request->request->get('prix'));
        $product->setQuantite($request->request->get('quantite'));
        $product->setDescription($request->request->get('description'));
        $product->setStatus($request->request->get('status') == '1');

        $errors = $validator->validate($product);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $field = $error->getPropertyPath();
                $errorMessages[$field][] = $error->getMessage();
            }

            return $this->render('product/edit.html.twig', [
                'product' => $product,
                'errors' => $errorMessages,
            ]);
        }

        $em->flush();

        $this->addFlash('success', sprintf('%s mis à jour avec succès.', $product->getNom()));
        return $this->redirectToRoute("app_products");
    }





#[Route('/product/{id}/status', name: 'product_update_status', methods: ['GET', 'POST'])]
    public function updateStatusProduct(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $product = $em->getRepository(Product::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Produit introuvable');
        }

        if ($request->isMethod('GET')) {
            return $this->render('product/status.html.twig', [
                'product' => $product,
            ]);
        }

        if ($request->request->get('_method') === 'PATCH') {
            $product->setStatus(false);
            $em->flush();

            $this->addFlash('success', 'Produit supprimé  avec succès.');

            return $this->redirectToRoute("app_products");
        }

        $this->addFlash('error', 'Méthode non autorisée.');
        return $this->redirectToRoute('product_update_status', ['id' => $id]);
    }


 
}
