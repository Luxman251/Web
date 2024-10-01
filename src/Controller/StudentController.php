<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }


    #[Route('/student/read',name:'app_read')]
    public function read(StudentRepository $repo):Response
    {
        $list = $repo->findAll();
        return $this->render('student/read.html.twig'
            ,['students'=>$list]);
    }
}
