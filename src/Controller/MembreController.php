<?php

namespace App\Controller;


use App\Entity\Membre;
use App\Form\MembreFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MembreRepository;


class MembreController extends AbstractController
{
  /**
    * @Route("/membre", name="liste_membre")
    */
    public function index(MembreRepository $membreRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $membre = new Membre();
        $form = $this->createForm(MembreFormType::class, $membre);
        $form->handleRequest($request);
        //  return new JsonResponse($Membre);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($membreRepository->findOneByNom(trim($form->get('nom')->getData()))){
                $this->addFlash('doublon',"Ce Membre existe déja");
                return $this->render('membre/liste.html.twig', [
                    'membres' => $membreRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($membre);
                $entityManager->flush();
                $membre = new Membre();
                $form = $this->createForm(MembreFormType::class, $membre);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('membre/liste.html.twig', [
            'membres' => $membreRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/deletemembre/{id}", name="delete_membre")
     */

    public function deleteMembre(Membre $membre, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $membre = $em->getRepository(Membre::class)->find($id);
        $em->remove($membre);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_membre');
    }


    /**
     * @Route("/membre_edit{id}", name="edit_membre")
     */
    public function edit(Membre $membre, MembreRepository $membreRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $Membre = new Membre();
        $form = $this->createForm(MembreFormType::class, $membre);
        $form->handleRequest($request);
        //  return new JsonResponse($Membre);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $membreRepository->findOneByNom(trim($form->get('nom')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $membre->getId()){
                $this->addFlash('doublon',"Cette Membre existe déja");
            }else{
                $entityManager->persist($membre);
                $entityManager->flush();
                $membre = new Membre();
                $form = $this->createForm(MembreFormType::class, $membre);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_membre');
            
            }

        }

        return $this->render('membre/edit.html.twig', [
            'membres' => $membreRepository->findAll(), 'form' => $form->createView(),
        ]);
    }


}
