<?php

namespace App\Controller\admin;

use App\Entity\Images;
use App\Entity\Projets;
use App\Form\ProjectType;
use App\Repository\ProjetsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(ProjetsRepository $repo)
    {
        $projet = $repo->findBy([], ["id" => "DESC"]);

        return $this->render('admin/index.html.twig', [
            "projet" => $projet
        ]);
    }

    /**
     * edit add projects
     * @Route("/admin/projet/create", name="createProject")
     * @Route("/admin/projet/{id}", name="modifProject")
     */

    public function editAddProject(Projets $projet = null, Request $req, EntityManagerInterface $manager){

        if(!$projet){
            $projet = new Projets();
        }

        $form = $this->createForm(ProjectType::class, $projet);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $modif = $projet->getId() !== null;

            // ADD IMAGES IN CASCADE 
            $images = $form->get('images')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Images();
                $img->setName($fichier);
                $projet->addImage($img);
            }

            $manager->persist($projet);
            $manager->flush();

            $this->addFlash("success", ($modif) ? "la modification a bien été effectuer" : "l'ajout a bien été effectuer");
            return $this->redirectToRoute("admin");
        }

        return $this->render('admin/AMprojet.html.twig',[
            "projet" => $projet,
            "form" => $form->createView(),
            "edit" => $projet->getId() !== null
        ]);
    }

    /**
     * delete
     * 
     * @Route("/admin/projet/{id}/delete", name="supProjet", methods="delete")
     */
    public function delete(Projets $projet, EntityManagerInterface $manager, Request $req){
        if ($this->isCsrfTokenValid('SUP'.$projet->getId(), $req->get('_token'))){

            $manager->remove($projet);
            $manager->flush();
            $this->addFlash("success", "La suppression a bien été éffectuée");
            return $this->redirectToRoute("admin");
        }
    }
}
