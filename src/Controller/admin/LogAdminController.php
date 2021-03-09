<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LogAdminController extends AbstractController
{
    /**
     * @Route("/admin/log", name="log_admin")
     */
    public function index(AuthenticationUtils $outils)
    {

        $erreur = $outils->getLastAuthenticationError();
        $identifiant = $outils->getLastUsername();
        
        return $this->render('admin/log.html.twig', [
            'erreur' => $erreur !== null,
            'identifiant' => $identifiant,
        ]);
        return $this->redirectToRoute('admin');
    }

        /**
     * permet la deconnexion
     *
     * @Route("/admin/logout", name="admin_logout")
     * @return void
     */
    public function logout(){

    }
    
}
