<?php

namespace Findo\Bundle\FinDoBundle\Controller;

use Findo\Bundle\FinDoBundle\Entity\ToDoItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Findo\Bundle\FinDoBundle\Form\ItemType;

/**
 * Class ToDoController
 * @package Findo\Bundle\FinDoBundle\Controller
 * @Route("/ToDo")
 *
 */
class ToDoController extends Controller
{

    /**
     * @Route("/index", name="index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $item = new ToDoItem();
        $form = $this->createFormBuilder($item)
            ->add('text', 'text')
            ->add('save', 'submit')
            ->getForm();
//            ->setAction($this->generateUrl('target_route'))
//            ->setMethod('GET')

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

//            return $this->redirect($this->generateUrl('index'));
        }

        return $this->render('FindoFinDoBundle:ToDo:index.html.twig', array(
            'form' => $form->createView(),
        ));

        $items = $this->getDoctrine()
            ->getRepository('FindoFinDoBundle:ToDoItem')
            ->findAll();


//        return array(
//            'items' => $items
//        );
    }

    /**
     * @Route("/create", name="create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        // create new item and give some dummy data for this example
        $item = new ToDoItem();
        $item->setText('neue aufgabe');

        $form = $this->createFormBuilder($item)
            ->add('text', 'text')
            ->add('save', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirect($this->generateUrl('index'));
//            return new Response(
//                'Created item id: '.$item->getId()
//            );

        }
        return $this->render('FindoFinDoBundle:ToDo:create.html.twig', array(
            'form' => $form->createView(),

        ));

    }


    /**
     * @Route("/edit/{id}", name="edit")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()
            ->getRepository('FindoFinDoBundle:ToDoItem')
            ->find($id);

        $form = $this->createFormBuilder($item)
            ->add('text', 'text')
            ->add('save', 'submit')
            ->getForm();

//        return $this->redirect($this->generateUrl('edit',array('id' => $item->getId())));
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirect($this->generateUrl('index'));
//            return new Response(
//                'Created item id: '.$item->getId()
//            );

        }
        return $this->render('FindoFinDoBundle:ToDo:create.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()
            ->getRepository('FindoFinDoBundle:ToDoItem')
            ->find($id);

        $em->remove($item);
        $em->flush();

        return $this->redirect($this->generateUrl('index'));
    }

    /**
     * @Route("/finish/{id}", name="finish")
     * @Template()
     */
    public function finishAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()
            ->getRepository('FindoFinDoBundle:ToDoItem')
            ->find($id);


        $item->setFinished(true);
        $em->flush();

        return $this->redirect($this->generateUrl('index'));

    }





}
