<?php

namespace Findo\Bundle\FinDoBundle\Controller;

use Findo\Bundle\FinDoBundle\Entity\ToDoItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mopa\Bundle\BootstrapBundle\Form\Type;

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
        //list all items
        $items = $this->getDoctrine()
        ->getRepository('FindoFinDoBundle:ToDoItem')
        ->findAll();

        // add new item
        $item = new ToDoItem();
        $form = $this->createFormBuilder($item)
            ->add('text', 'text', array(
                'required' => true,
                'attr' => array(
                    'size' => '35px',
                    'placeholder' => 'next task..',
                )
            ))
            ->add('save', 'submit')
            ->getForm();

//        $form = $this->createAction($request, $item);

        $form->handleRequest($request);

        if ($form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirect($this->generateUrl('index'));
            return new Response(
                'Created item id: '.$item->getId()
            );
        }

//        if ($request->isXmlHttpRequest()) {
//            $json = json_encode(array(
//                'id' => $item->getId(),
//                'finished' => $item->getFinished(),
//            ));
//
//            $response = new Response($json);
//            $response->headers->set('Content-Type', 'application/json');
//            return $response;
//        };

        return $this->render('FindoFinDoBundle:ToDo:index.html.twig', array(
            'items' => $items,
            'item' => $item,
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/build", name="build")
     * @Template()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('textfield', 'text', array(
                'label' => "Label name",
                'help_block' => 'Associated help text!',
                'attr' => array(
                    'placeholder' => "Some text",
                )
            ))
            ->add('Checkboxes_Inline', 'choice', array(
                'label_render'        => false,
                'help_block'  => 'Expanded and multiple (inline)',
                'multiple'     => true,
                'expanded'     => true,
                'choices'      => array('1' => 'one', '2' => 'two'),
                'widget_type'  => "inline"
            ))
        ;
    }

    /**
     * @Route("/create", name="create")
     * @Template()
     */
    public function createAction(Request $request, $item)
    {
        // create new item and give some dummy data for this example
//        $item = new ToDoItem();
//        $item->setText('design the app logo');

//        $form = $this->createFormBuilder($item)
//            ->add('text', 'text', array(
//                'required' => true,
//                'attr' => array(
//                    'size' => '35',
//                    'placeholder' => 'next task..',
//                )
//            ))
////            ->add('finished', 'checkbox', array(
////                'label' => 'Done',
////                'required' => false,
////            ))
//            ->add('save', 'submit')
//            ->getForm();

        //$form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirect($this->generateUrl('index'));
            return new Response(
                'Created item id: '.$item->getId()
            );

        }
//        return $this->render('FindoFinDoBundle:ToDo:create.html.twig', array(
//            'form' => $form,//->createView(),
//            'item' => $item,
//
//        ));

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
     * @Route("/finish/{id}", name="finished")
     * @Template()
     */
    public function finishAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()
            ->getRepository('FindoFinDoBundle:ToDoItem')
            ->find($id);


        $item->setFinished(true);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            $json = json_encode(array(
                'id' => $item->getId(),
                'finished' => $item->getFinished(),
            ));

            $response = new Response($json);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return $this->redirect($this->generateUrl('index'));

    }





}
