<?php

namespace App\Controller;


use App\Entity\Projet;
use App\Form\ProjetType;
use App\Form\ProjetsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ProjetController extends AbstractController
{
  /**
    * @Route("/projet", name="liste_projet")
    */
    public function index(ProjetRepository $projetRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        //  return new JsonResponse($Projet);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($projetRepository->findOneByNomProjet(trim($form->get('nomProjet')->getData()))){
                $this->addFlash('doublon',"Ce Projet existe déja");
                return $this->render('Projet/liste.html.twig', [
                    'Projets' => $projetRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($projet);
                $entityManager->flush();
                $Projet = new Projet();
                $form = $this->createForm(ProjetType::class, $projet);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('projet/liste.html.twig', [
            'projets' => $projetRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/deleteprojet/{id}", name="delete_projet")
     */

    public function deleteProjet(Projet $projet, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $projet = $em->getRepository(Projet::class)->find($id);
        $em->remove($projet);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_projet');
    }


    /**
     * @Route("/projet_edit{id}", name="edit_projet")
     */
    public function edit(Projet $projet, ProjetRepository $projetRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $Projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        //  return new JsonResponse($Projet);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $projetRepository->findOneByNomProjet(trim($form->get('nomProjet')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $projet->getId()){
                $this->addFlash('doublon',"Cet Projet existe déja");
            }else{
                $entityManager->persist($projet);
                $entityManager->flush();
                $projet = new Projet();
                $form = $this->createForm(ProjetType::class, $projet);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_projet');
            
            }

        }

        return $this->render('projet/edit.html.twig', [
            'projets' => $projetRepository->findAll(), 'form' => $form->createView(),
        ]);
    }



      /**
     *@Route("/encour", name="desactive_encour")
     */
    public function ActionEncour(Request $request, EntityManagerInterface $entityManager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $projet = $entityManager->getRepository(Projet::class)->find($id);
        $projet->setprojetComplet(1);
        $entityManager->persist($projet);
        $entityManager->flush();
        $this->addFlash(
            'active',
            "Ce compte a été active avec sucess !!!"
        );
        return $this->redirectToRoute('liste_projet');
    }



     /**
     *@Route("/terminer", name="active_terminer")
     */
    public function ActionActive(Request $request, EntityManagerInterface $entityManager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $projet = $entityManager->getRepository(Projet::class)->find($id);
        $projet->setprojetComplet(0);
        $entityManager->persist($projet);
        $entityManager->flush();
        $this->addFlash(
            'active',
            "Ce compte a été active avec sucess !!!"
        );
        return $this->redirectToRoute('liste_projet');
    }



    /**
    * @Route("/projets", name="liste_projets")
    */
    public function indexfin(ProjetRepository $projetRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $projet = new Projet();
        $form = $this->createForm(ProjetsType::class, $projet);
        $form->handleRequest($request);
        //  return new JsonResponse($Projet);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($projetRepository->findOneByNomProjet(trim($form->get('nomProjet')->getData()))){
                $this->addFlash('doublon',"Ce Projet existe déja");
                return $this->render('projets/liste.html.twig', [
                    'Projets' => $projetRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($projet);
                $entityManager->flush();
                $Projet = new Projet();
                $form = $this->createForm(ProjetsType::class, $projet);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('projets/liste.html.twig', [
            'projets' => $projetRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/deleteprojets/{id}", name="delete_projets")
     */

    public function deleteProjetfin(Projet $projet, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $projet = $em->getRepository(Projet::class)->find($id);
        $em->remove($projet);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_projet');
    }


    /**
     * @Route("/projets_edit{id}", name="edit_projets")
     */
    public function editfin(Projet $projet, ProjetRepository $projetRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $Projet = new Projet();
        $form = $this->createForm(ProjetsType::class, $projet);
        $form->handleRequest($request);
        //  return new JsonResponse($Projet);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $projetRepository->findOneByNomProjet(trim($form->get('nomProjet')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $projet->getId()){
                $this->addFlash('doublon',"Cet Projet existe déja");
            }else{
                $entityManager->persist($projet);
                $entityManager->flush();
                $projet = new Projet();
                $form = $this->createForm(ProjetsType::class, $projet);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_projet');
            
            }

        }

        return $this->render('projets/edit.html.twig', [
            'projets' => $projetRepository->findAll(), 'form' => $form->createView(),
        ]);
    }



      /**
     *@Route("/encours", name="desactive_encours")
     */
    public function ActionEncours(Request $request, EntityManagerInterface $entityManager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $projet = $entityManager->getRepository(Projet::class)->find($id);
        $projet->setprojetComplet(1);
        $entityManager->persist($projet);
        $entityManager->flush();
        $this->addFlash(
            'active',
            "Ce compte a été active avec sucess !!!"
        );
        return $this->redirectToRoute('liste_projet');
    }



     /**
     *@Route("/terminers", name="active_terminers")
     */
    public function ActionActives(Request $request, EntityManagerInterface $entityManager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $projet = $entityManager->getRepository(Projet::class)->find($id);
        $projet->setprojetComplet(0);
        $entityManager->persist($projet);
        $entityManager->flush();
        $this->addFlash(
            'active',
            "Ce compte a été active avec sucess !!!"
        );
        return $this->redirectToRoute('liste_projet');
    }


    
    
}
