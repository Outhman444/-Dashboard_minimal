<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Knp\Component\Pager\PaginatorInterface;

final class CategoryController extends AbstractController
{
    #[Route('/categories/{page}', name: 'app_categories', requirements: ['page' => '\\d+'], defaults: ['page' => 1], methods: ['GET'])]
    public function index(int $page, CategorieRepository $repo, PaginatorInterface $paginator): Response
    {
        
        #hna tartib prduit mn akbar id 
        $queryBuilder = $repo->createListQueryBuilder();

        
        $pagination = $paginator->paginate(
            $queryBuilder, 
            $page,        
            5         
        );

        return $this->render('categorie/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/categorie/new', name: 'categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        if ($request->isMethod('GET')) {
            return $this->render('categorie/new.html.twig', [
                'oldData' => [],
                'errors' => [],
            ]);
        }

        $categorie = new Categorie();
        $categorie->setNom($request->request->get('nom'));
        $categorie->setDescription($request->request->get('description'));
        $categorie->setStatus($request->request->get('status') == '1');

        $errors = $validator->validate($categorie);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $field = $error->getPropertyPath();
                $errorMessages[$field][] = $error->getMessage();
            }

            return $this->render('categorie/new.html.twig', [
                'errors' => $errorMessages,
                'oldData' => $request->request->all(),
            ]);
        }

        $em->persist($categorie);
        $em->flush();

        $this->addFlash('success', 'Categorie "' . $categorie->getNom() . '" ajoutée avec succès.');

        return $this->redirectToRoute('app_categories');
    }

    #[Route('/categorie/{id}', name: 'categorie_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $categorie = $em->getRepository(Categorie::class)->find($id);
        if (!$categorie) {
            throw $this->createNotFoundException('Categorie introuvable');
        }

        if ($request->isMethod('GET')) {
            return $this->render('categorie/edit.html.twig', ['categorie' => $categorie]);
        }

        $categorie->setNom($request->request->get('nom'));
        $categorie->setDescription($request->request->get('description'));
        $categorie->setStatus($request->request->get('status') == '1');

        $errors = $validator->validate($categorie);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $field = $error->getPropertyPath();
                $errorMessages[$field][] = $error->getMessage();
            }

            return $this->render('categorie/edit.html.twig', [
                'categorie' => $categorie,
                'errors' => $errorMessages,
            ]);
        }

        $em->flush();

        $this->addFlash('success', sprintf('%s mis à jour avec succès.', $categorie->getNom()));
        return $this->redirectToRoute('app_categories');
    }

    #[Route('/categorie/{id}/status', name: 'categorie_update_status', methods: ['GET', 'POST'])]
    public function updateStatus(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $categorie = $em->getRepository(Categorie::class)->find($id);
        if (!$categorie) {
            throw $this->createNotFoundException('Categorie introuvable');
        }

        if ($request->isMethod('GET')) {
            return $this->render('categorie/status.html.twig', [
                'categorie' => $categorie,
            ]);
        }

        if ($request->request->get('_method') === 'PATCH') {
            $categorie->setStatus(false);
            $em->flush();

            $this->addFlash('success', 'Categorie supprimée avec succès.');

            return $this->redirectToRoute('app_categories');
        }

        $this->addFlash('error', 'Méthode non autorisée.');
        return $this->redirectToRoute('categorie_update_status', ['id' => $id]);
    }
}
