<?php

/**
 * Created by PhpStorm.
 * User: Mac
 * Date: 31/03/2018
 * Time: 15:22
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Message controller.
 *
 */
class MessageController extends Controller
{
    /**
     * @Route("/message", name="message")
     *
     */
    public function indexAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm('AppBundle\Form\MessageType', $message);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $utilisateur = $this->get('security.token_storage')->getToken()->getUser();
        $id_user = $utilisateur->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setIdSender($id_user);
            $em->persist($message);
            $em->flush();
        }

        $messages_sent = $this->getDoctrine()->getRepository(Message::class)->findBy(
            array('id_sender' => $id_user)
        );

        $messages_received = $this->getDoctrine()->getRepository(Message::class)->findBy(
            array('id_receiver' => $id_user)
        );

        return $this->render('message/index.html.twig', array(
            'messages_sent' => $messages_sent,
            'messages_received' => $messages_received,
            'form' => $form->createView(),
        ));
    }
}