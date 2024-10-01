<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthoerController extends AbstractController
{
    #[Route(path: '/author/{name}', name: 'show_author', defaults:["name" => null])]

    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'nom' => $name,
        ]);
    }

    #[Route(path: '/authors', name: 'list_authors')]

    public function listAuthors(): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpeg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpeg','username' => 'William Shakespeare', 'email' =>  'william.shakespeare@gmail.com', 'nb_books' => 200),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpeg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );

        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route(path: '/author/{id}/details', name: 'author_details')]
    public function authorDetails(int $id): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpeg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpeg','username' => 'William Shakespeare', 'email' =>  'william.shakespeare@gmail.com', 'nb_books' => 200),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpeg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );

        // Trouver l'auteur par ID
        $author = null;
        foreach ($authors as $a) {
            if ($a['id'] == $id) {
                $author = $a;
                break;
            }
        }

        // Si l'auteur n'est pas trouvé, lancer une exception 404
        if (!$author) {
            throw $this->createNotFoundException('Author not found');
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);
    }



#[Route(path:'/read',name:'app_read')]
public function read(AuthorRepository $repo):Response
{
$list = $repo->findAll();
return $this->render('author/read.html.twig'
     ,['authors'=>$list]);
}

    #[Route(path:'/delete/{id}',name:'app_delete')]
public function delete($id,ManagerRegistry $doctrine)
{
    $repository=$doctrine->getRepository(Author::class);
    $author=$repository->find($id);
    $entityManager=$doctrine->getManager();
    $entityManager->remove($author);
    $entityManager->flush();
    $this-> addFlash('success','author deleted !');
    return $this->redirectToRoute('app_read');

}
    #[Route(path:'/ajout',name:'app_ajout')]
public function create(ManagerRegistry $doctrine,\Symfony\Component\HttpFoundation\Request $request){
        $author= new Author();
       $form= $this->createForm(AuthorType::class,$author);//creer un formulaire à partir du formtype
        $form->handleRequest($request);//gerer les données recus à partir du form
        if($form->isSubmitted() && $form->isValid() ){
            $em = $doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_read');
        }

    return $this->renderForm('author/add.html.twig',array('formA'=>$form));
}






    #[Route(path:'/update/{id}',name:'update')]
    public function update(AuthorRepository $repository,ManagerRegistry $doctrine,\Symfony\Component\HttpFoundation\Request $request,$id ){
        $author=$repository->find($id);
        $form= $this->createForm(AuthorType::class,$author);//creer un formulaire à partir du formtype
        $form->handleRequest($request);//gerer les données recus à partir du form
        if($form->isSubmitted() && $form->isValid() ){
            $em = $doctrine->getManager();

            $em->flush();
            return $this->redirectToRoute('app_read');
        }

        return $this->renderForm('author/update.html.twig',array('formA'=>$form));
    }




}