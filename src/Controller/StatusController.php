<?php

namespace App\Controller;


use App\Entity\Status;
use App\Form\StatusType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StatusRepository;

class StatusController extends AbstractController
{
  /**
    * @Route("/status", name="liste_status")
    */
    public function index(StatusRepository $statusRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);
        //  return new JsonResponse($status);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($statusRepository->findOneByNomStatus(trim($form->get('nomStatus')->getData()))){
                $this->addFlash('doublon',"Ce status existe déja");
                return $this->render('status/liste.html.twig', [
                    'statuss' => $statusRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($status);
                $entityManager->flush();
                $status = new Status();
                $form = $this->createForm(StatusType::class, $status);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('status/liste.html.twig', [
            'status' => $statusRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/deletestatus/{id}", name="delete_status")
     */

    public function deletestatus(Status $status, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $status = $em->getRepository(Status::class)->find($id);
        $em->remove($status);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_status');
    }


    /**
     * @Route("/status_edit{id}", name="edit_status")
     */
    public function edit(Status $status, StatusRepository $statusRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $status = new status();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);
        //  return new JsonResponse($status);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $statusRepository->findOneByNomStatus(trim($form->get('nomStatus')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $status->getId()){
                $this->addFlash('doublon',"Cette status existe déja");
            }else{
                $entityManager->persist($status);
                $entityManager->flush();
                $status = new Status();
                $form = $this->createForm(StatusType::class, $status);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_status');
            
            }

        }

        return $this->render('status/edit.html.twig', [
            'status' => $statusRepository->findAll(), 'form' => $form->createView(),
        ]);
    }


}
