<?php

namespace App\Controller;


use App\Entity\Predecesseur;
use App\Form\PredecesseurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PredecesseurRepository;

class PredecesseurController extends AbstractController
{
  /**
    * @Route("/Predecesseur", name="liste_predecesseur")
    */
    public function index(PredecesseurRepository $predecesseurRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $predecesseur = new Predecesseur();
        $form = $this->createForm(PredecesseurType::class, $predecesseur);
        $form->handleRequest($request);
        //  return new JsonResponse($Predecesseur);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($predecesseurRepository->findOneByNomPredecesseur(trim($form->get('nomPredecesseur')->getData()))){
                $this->addFlash('doublon',"Ce Predecesseur existe déja");
                return $this->render('predecesseur/liste.html.twig', [
                    'predecesseurs' => $predecesseurRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($predecesseur);
                $entityManager->flush();
                $predecesseur = new Predecesseur();
                $form = $this->createForm(PredecesseurType::class, $predecesseur);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('predecesseur/liste.html.twig', [
            'predecesseurs' => $predecesseurRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/deletepredecesseur/{id}", name="delete_predecesseur")
     */

    public function deletePredecesseur(Predecesseur $predecesseur, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $predecesseur = $em->getRepository(Predecesseur::class)->find($id);
        $em->remove($predecesseur);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_predecesseur');
    }


    /**
     * @Route("/predecesseur_edit{id}", name="edit_predecesseur")
     */
    public function edit(Predecesseur $predecesseur, PredecesseurRepository $predecesseurRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $Predecesseur = new Predecesseur();
        $form = $this->createForm(PredecesseurType::class, $predecesseur);
        $form->handleRequest($request);
        //  return new JsonResponse($Predecesseur);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $predecesseurRepository->findOneByNomPredecesseur(trim($form->get('nomPredecesseur')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $predecesseur->getId()){
                $this->addFlash('doublon',"Ce Predecesseur existe déja");
            }else{
                $entityManager->persist($predecesseur);
                $entityManager->flush();
                $predecesseur = new Predecesseur();
                $form = $this->createForm(PredecesseurType::class, $predecesseur);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_predecesseur');
            
            }

        }

        return $this->render('predecesseur/edit.html.twig', [
            'predecesseurs' => $predecesseurRepository->findAll(), 'form' => $form->createView(),
        ]);
    }


}
