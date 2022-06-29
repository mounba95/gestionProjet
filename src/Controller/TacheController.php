<?php

namespace App\Controller;


use App\Entity\Tache;
use App\Form\TacheType;
use App\Form\TachesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TacheRepository;

class TacheController extends AbstractController
{
  /**
    * @Route("/tache", name="liste_tache")
    */
    public function index(TacheRepository $tacheRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);
        //  return new JsonResponse($tache);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($tacheRepository->findOneByNomTache(trim($form->get('nomTache')->getData()))){
                $this->addFlash('doublon',"Ce tache existe déja");
                return $this->render('tache/liste.html.twig', [
                    'taches' => $tacheRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($tache);
                $entityManager->flush();
                $tache = new tache();
                $form = $this->createForm(TacheType::class, $tache);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('tache/liste.html.twig', [
            'taches' => $tacheRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/deletetache/{id}", name="delete_tache")
     */

    public function deletetache(Tache $tache, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository(Tache::class)->find($id);
        $em->remove($tache);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_tache');
    }


    /**
     * @Route("/tache_edit{id}", name="edit_tache")
     */
    public function edit(Tache $tache, TacheRepository $tacheRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $tache = new tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);
        //  return new JsonResponse($tache);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $tacheRepository->findOneByNomTache(trim($form->get('nomTache')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $tache->getId()){
                $this->addFlash('doublon',"Cette tache existe déja");
            }else{
                $entityManager->persist($tache);
                $entityManager->flush();
                $tache = new Tache();
                $form = $this->createForm(TachesType::class, $tache);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_tache');
            
            }

        }

        return $this->render('tache/edit.html.twig', [
            'taches' => $tacheRepository->findAll(), 'form' => $form->createView(),
        ]);
    }



 /**
    * @Route("/taches", name="liste_taches")
    */
    public function indexfin(TacheRepository $tacheRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $tache = new Tache();
        $form = $this->createForm(TachesType::class, $tache);
        $form->handleRequest($request);
        //  return new JsonResponse($tache);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($tacheRepository->findOneByNomTache(trim($form->get('nomTache')->getData()))){
                $this->addFlash('doublon',"Ce tache existe déja");
                return $this->render('taches/liste.html.twig', [
                    'taches' => $tacheRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($tache);
                $entityManager->flush();
                $tache = new tache();
                $form = $this->createForm(TachesType::class, $tache);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('taches/liste.html.twig', [
            'taches' => $tacheRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/deletetaches/{id}", name="delete_taches")
     */

    public function deletetachefin(Tache $tache, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository(Tache::class)->find($id);
        $em->remove($tache);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_tache');
    }


    /**
     * @Route("/taches_edit{id}", name="edit_taches")
     */
    public function editfin(Tache $tache, TacheRepository $tacheRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $tache = new tache();
        $form = $this->createForm(TachesType::class, $tache);
        $form->handleRequest($request);
        //  return new JsonResponse($tache);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $tacheRepository->findOneByNomTache(trim($form->get('nomTache')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $tache->getId()){
                $this->addFlash('doublon',"Cette tache existe déja");
            }else{
                $entityManager->persist($tache);
                $entityManager->flush();
                $tache = new Tache();
                $form = $this->createForm(TachesType::class, $tache);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_tache');
            
            }

        }

        return $this->render('taches/edit.html.twig', [
            'taches' => $tacheRepository->findAll(), 'form' => $form->createView(),
        ]);
    }


}
