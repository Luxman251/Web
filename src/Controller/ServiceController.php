<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceController extends AbstractController
{
    #[Route('/service/{name}', name: 'app_service')]
    public function index($name): Response
    {
        return $this->render('showService.html.twig',['name'=> $name]
        );
    }/*
#[Route('/goindex',name:'app_go')]
public function goToIndex () : Response{
        return ();
}*/


}
