<?php /** @noinspection ALL */

namespace App\Controller;

use App\Entity\User;
use App\Form\ModificationUserFormType;
use App\Form\ModificationUserPWFormType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/liste", name="liste_user")
     */
    public function liste(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();


        //add user
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($user);
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setEtat(1);
            $user->setActivationToken(md5(uniqid()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            if ($entityManager) {
                $this->addFlash(
                    'register',
                    "Enregistrement effectué avec succès !!!"
                );
                $users = $repo->findAll();
                $user = new User();
                $form = $this->createForm(RegistrationFormType::class, $user);
                return $this->render('registration/liste.html.twig', ['form' => $form->createView(),
                    'users' => $users
                ]);
            } else {
                $this->addFlash(
                    'nonregister',
                    "Erreur !!!"
                );
            }

        }
        return $this->render('registration/liste.html.twig', ['form' => $form->createView(),
            'users' => $users
        ]);

    }

    /**
     * @Route("/deleteUser/{id}", name="delete_user")
     */

    public function deleteUser(User $user, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_user');
    }

    /**
     * @Route("/profil{id}", name="profil_user")
     */

    public function profilUser($id, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repo = $this->getDoctrine()->getRepository(User::class);
        //add user
        $user = $repo->findOneById($id);
        $form = $this->createForm(ModificationUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setEtat(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'register',
                "Modification effectué avec succès !!!"
            );
            $user = $repo->findOneById($id);
            $form = $this->createForm(ModificationUserFormType::class, $user);
            return $this->render('registration/profil.html.twig', ['form' => $form->createView(),
                'user' => $user
            ]);
        }

        return $this->render('registration/profil.html.twig', ['form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/modifierUser{id}", name="edit_user")
     */
    public function editUser( $id, Request $request): Response
    {
       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();

        //add user
        $user = $repo->findOneById($id);
        $form = $this->createForm(ModificationUserPWFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

            $user->setEtat(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'register',
                "Modification effectuer avec succer !!!"
            );
            return $this->redirectToRoute('liste_user');
        }

        return $this->render('registration/edit.html.twig', ['form' => $form->createView(),
            'users' => $users
        ]);

    }


}
