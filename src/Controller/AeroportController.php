<?php

namespace App\Controller;

use App\Entity\Aeroport;
use App\Entity\Author;
use App\Form\AeroportType;
use App\Form\AuthorType;
use App\Repository\AeroportRepository;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AeroportController extends AbstractController
{
    #[Route(path:'/readAeroport',name:'app_readAeroport')]
    public function read(AeroportRepository $repo):Response
    {
        $list = $repo->findAll();
        return $this->render('aeroport/read.html.twig'
            ,['aeroports'=>$list]);
    }




    #[Route(path:'/ajoutAero',name:'app_ajoutAero')]
    public function create(ManagerRegistry $doctrine,\Symfony\Component\HttpFoundation\Request $request){
        $aeroport= new Aeroport();
        $form= $this->createForm(AeroportType::class,$aeroport);//creer un formulaire à partir du formtype
        $form->handleRequest($request);//gerer les données recus à partir du form
        if($form->isSubmitted() && $form->isValid() ){
            $em = $doctrine->getManager();
            $em->persist($aeroport);
            $em->flush();
            return $this->redirectToRoute('app_readAeroport');
        }

        return $this->renderForm('aeroport/addAero.html.twig',array('formA'=>$form));
    }






    #[Route(path:'/updateAero/{id}',name:'update_Aero')]
    public function update(AeroportRepository $repository,ManagerRegistry $doctrine,\Symfony\Component\HttpFoundation\Request $request,$id ){
        $aeroport=$repository->find($id);
        $form= $this->createForm(AeroportType::class,$aeroport);//creer un formulaire à partir du formtype
        $form->handleRequest($request);//gerer les données recus à partir du form
        if($form->isSubmitted() && $form->isValid() ){
            $em = $doctrine->getManager();

            $em->flush();
            return $this->redirectToRoute('app_readAeroport');
        }

        return $this->renderForm('aeroport/updateAero.html.twig',array('formA'=>$form));
    }






}
