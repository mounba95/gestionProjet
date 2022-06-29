<?php

namespace App\Controller;


use App\Entity\Equipe;
use App\Form\EquipeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class EquipeController extends AbstractController
{
  /**
    * @Route("/equipe", name="liste_equipe")
    */
    public function index(EquipeRepository $equipeRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);
        //  return new JsonResponse($Equipe);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($equipeRepository->findOneByNomEquipe(trim($form->get('nomEquipe')->getData()))){
                $this->addFlash('doublon',"Ce Equipe existe déja");
                return $this->render('equipe/liste.html.twig', [
                    'equipes' => $equipeRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($equipe);
                $entityManager->flush();
                $equipe = new Equipe();
                $form = $this->createForm(EquipeType::class, $equipe);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('equipe/liste.html.twig', [
            'equipes' => $equipeRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/deleteequipe/{id}", name="delete_equipe")
     */

    public function deleteEquipe(Equipe $equipe, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $equipe = $em->getRepository(Equipe::class)->find($id);
        $em->remove($equipe);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_equipe');
    }


    /**
     * @Route("/equipe_edit{id}", name="edit_equipe")
     */
    public function edit(Equipe $equipe, EquipeRepository $equipeRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $Equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);
        //  return new JsonResponse($Equipe);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $equipeRepository->findOneByNomEquipe(trim($form->get('nomEquipe')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $equipe->getId()){
                $this->addFlash('doublon',"Cette Equipe existe déja");
            }else{
                $entityManager->persist($equipe);
                $entityManager->flush();
                $equipe = new Equipe();
                $form = $this->createForm(EquipeType::class, $equipe);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_equipe');
            
            }

        }

        return $this->render('equipe/edit.html.twig', [
            'equipes' => $equipeRepository->findAll(), 'form' => $form->createView(),
        ]);
    }


     /**
     *@Route("/externe", name="desactive_interne")
     */
    public function ActionDesactivation(Request $request, EntityManagerInterface $entityManager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $equipe = new Equipe();
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $equipe = $entityManager->getRepository(Equipe::class)->find($id);
        $equipe->setisExternal(0);
        $entityManager->persist($equipe);
        $entityManager->flush();
        $this->addFlash(
            'desactive',
            "Ce compte a été desactive avec sucess !!!"
        );
        return $this->redirectToRoute('liste_equipe');
    }
    /**
     *@Route("/interne", name="active_interne")
     */
    public function ActionActive(Request $request, EntityManagerInterface $entityManager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->query->get('id');
        $equipe = $entityManager->getRepository(Equipe::class)->find($id);
        $equipe->setisExternal(1);
        $entityManager->persist($equipe);
        $entityManager->flush();
        $this->addFlash(
            'active',
            "Ce compte a été active avec sucess !!!"
        );
        return $this->redirectToRoute('liste_equipe');
    }

}
