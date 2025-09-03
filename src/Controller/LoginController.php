<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    // had route /login bach luser y9dr yd5ol llogin form
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // ila kan user deja authentifié, redirect l dashboard
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }

        // jlb ay error li w9a f login lakhir
        $error = $authenticationUtils->getLastAuthenticationError();

        // jlb last email li dakhl luser
        $lastUsername = $authenticationUtils->getLastUsername();

      

        // 3rd lpage login m3a last_username w error
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
          
        ]);
    }

    
    // had route /logout bach luser y9dr ykhrj mn session
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        ///////////////////////////////////////////
    }
}
