<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller
{
    /**
     * Lists all utilisateur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();

        return $this->render('index/index.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }

    /**
     * Creates a new utilisateur entity.
     *
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm('AppBundle\Form\UtilisateurType', $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $password = $passwordEncoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($password);
            $utilisateur->setConfirm(false);

            $em->persist($utilisateur);
            $em->flush();

            $message = (new \Swift_Message('Email de confirmation'))
                ->setFrom('lilyshade21@gmail.com')
                ->setTo($utilisateur->getEmail())
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/registration.html.twig',
                        array('user' => $utilisateur)
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', 'Bien inscrit ! Un email vous a été envoyé pour confirmer votre compte.');

            return $this->redirectToRoute('security_login');
        }

        return $this->render('utilisateur/new.html.twig', array(
            'user' => $utilisateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a utilisateur entity.
     *
     */
    public function showAction(Request $request)
    {
        $utilisateur = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createDeleteForm($utilisateur);
        $form->handleRequest($request);
        return $this->render('utilisateur/show.html.twig', array('delete_form' => $form->createView()));
    }

    /**
     * @Route("/{id}/login", name="login_check")
     */
    public function loginCheckAction($id)
    {
        $utilisateur = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->find($id);
        $utilisateur->setConfirm(true);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('security_login');
    }

    /**
     * Displays a form to edit an existing utilisateur entity.
     *
     */
    public function editAction(Request $request, Utilisateur $utilisateur, UserPasswordEncoderInterface $passwordEncoder)
    {
        /* $editPassForm = $this->createForm('AppBundle\Form\EditPassType', $utilisateur);
         $editEmailForm = $this->createForm('AppBundle\Form\EditEmailType', $utilisateur);
         $editPassForm->handleRequest($request);
         $editEmailForm->handleRequest($request);

         if ($editEmailForm->isSubmitted() && $editEmailForm->isValid()) {
             $this->getDoctrine()->getManager()->flush();

             return $this->redirectToRoute('user_show', array('id' => $utilisateur->getId()));
         }
         /*if ($editPassForm->isSubmitted() && $editPassForm->isValid()) {
             $passFormContent = $editPassForm->getData();
             $plainPassword = $passwordEncoder->encodePassword($utilisateur, $passFormContent->getPlainPassword());
             if ($plainPassword == $utilisateur->getPassword()) {
                 $this->getDoctrine()->getManager()->flush();

                 return $this->redirectToRoute('user_show', array('id' => $utilisateur->getId()));
             }
         }*/

        return $this->render('utilisateur/edit.html.twig', array(
            'utilisateur' => $utilisateur,
            /*'edit_email_form' => $editEmailForm->createView(),
            'edit_password_form' => $editPassForm->createView(),*/
        ));
    }

    /**
     * Deletes a utilisateur entity.
     *
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {
        $utilisateur = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createDeleteForm($utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a utilisateur entity.
     *
     * @param Utilisateur $utilisateur The utilisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Utilisateur $utilisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $utilisateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
