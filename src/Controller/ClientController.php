<?php

namespace App\Controller;


use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClientRepository;

class ClientController extends AbstractController
{
  /**
    * @Route("/client", name="liste_client")
    */
    public function index(ClientRepository $clientRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        //  return new JsonResponse($Client);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($clientRepository->findOneByNomClient(trim($form->get('nomClient')->getData()))){
                $this->addFlash('doublon',"Ce Client existe déja");
                return $this->render('client/liste.html.twig', [
                    'clients' => $clientRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($client);
                $entityManager->flush();
                $Client = new Client();
                $form = $this->createForm(ClientType::class, $client);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('client/liste.html.twig', [
            'clients' => $clientRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/deleteclient/{id}", name="delete_client")
     */

    public function deleteClient(Client $client, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository(Client::class)->find($id);
        $em->remove($client);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_client');
    }


    /**
     * @Route("/client_edit{id}", name="edit_client")
     */
    public function edit(Client $client, ClientRepository $clientRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $Client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        //  return new JsonResponse($Client);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $clientRepository->findOneByNomClient(trim($form->get('nomClient')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $client->getId()){
                $this->addFlash('doublon',"Ce Client existe déja");
            }else{
                $entityManager->persist($client);
                $entityManager->flush();
                $client = new Client();
                $form = $this->createForm(ClientType::class, $client);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_client');
            
            }

        }

        return $this->render('client/edit.html.twig', [
            'clients' => $clientRepository->findAll(), 'form' => $form->createView(),
        ]);
    }


}
