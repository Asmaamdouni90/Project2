<?php

namespace App\Controller;
use App\Form\ClassroomType;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    /**
     * @Route("/list", name="listclassroom")
     */
    public function list(ClassroomRepository $classroomRepository )
    {
        $tabclassroom =$classroomRepository->findAll();
     // $listClassroom=$this->getDoctrine()->getRepository(Classroom::class)->findAll();
       return $this->render('classroom/list.html.twig',array('tabclassroom'=>$tabclassroom));
    }
    /**
     * @Route("/add", name="addclassroom")
     */
  public function add(\Symfony\Component\HttpFoundation\Request $request)
  {
     $classroom = new Classroom;
      $form=$this->createForm(ClassroomType::class,$classroom);
      $form->handleRequest($request);
       if ($form ->isSubmitted()){
           $em=$this->getDoctrine()->getManager();
           $em->persist($classroom);
           $em->flush();
           return $this->redirectToRoute('listclassroom');

       }
      return $this->render('classroom/add.html.twig',array('formClassroom'=>$form->createView()));
  }

    /**
     * @Route("/update{id}", name="updateclassroom")
     */
    public function update($id,\Symfony\Component\HttpFoundation\Request $request)
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $form=$this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request);
        if ($form ->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listclassroom');

        }
        return $this->render('classroom/update.html.twig',array('formClassroom'=>$form->createView()));
    }

}
