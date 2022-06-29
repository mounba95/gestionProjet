<?php

namespace App\Controller;


use App\Entity\Soustache;
use App\Form\SoustacheType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SoustacheRepository;

class SoustacheController extends AbstractController
{
  /**
    * @Route("/soustache", name="liste_soustache")
    */
    public function index(SoustacheRepository $soustacheRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $soustache = new Soustache();
        $form = $this->createForm(SoustacheType::class, $soustache);
        $form->handleRequest($request);
        //  return new JsonResponse($soustache);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($soustacheRepository->findOneByNomSoutache(trim($form->get('nomSoutache')->getData()))){
                $this->addFlash('doublon',"Ce soustache existe déja");
                return $this->render('soustache/liste.html.twig', [
                    'soustaches' => $soustacheRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($soustache);
                $entityManager->flush();
                $soustache = new Soustache();
                $form = $this->createForm(SoustacheType::class, $soustache);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('soustache/liste.html.twig', [
            'soustaches' => $soustacheRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/deletesoustache/{id}", name="delete_soustache")
     */

    public function deletesoustache(Soustache $soustache, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $soustache = $em->getRepository(Soustache::class)->find($id);
        $em->remove($soustache);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_soustache');
    }


    /**
     * @Route("/soustache_edit{id}", name="edit_soustache")
     */
    public function edit(Soustache $soustache, SoustacheRepository $soustacheRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $soustache = new soustache();
        $form = $this->createForm(SoustacheType::class, $soustache);
        $form->handleRequest($request);
        //  return new JsonResponse($soustache);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $soustacheRepository->findOneByNomSoutache(trim($form->get('nomSoutache')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $soustache->getId()){
                $this->addFlash('doublon',"Cette soustache existe déja");
            }else{
                $entityManager->persist($soustache);
                $entityManager->flush();
                $soustache = new Soustache();
                $form = $this->createForm(SoustacheType::class, $soustache);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_soustache');
            
            }

        }

        return $this->render('soustache/edit.html.twig', [
            'soustaches' => $soustacheRepository->findAll(), 'form' => $form->createView(),
        ]);
    }


}
