<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    private array $authors = [
        1 => ['id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
        2 => ['id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
        3 => ['id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
     ];
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/author/show/{name}', name: 'author_name')]
    public function showAuthor(string $name): Response
    {
        return $this->render('author/show.html.twig', ['name' => $name]);
    }
    #[Route('/author/list', name: 'author_list')]
    public function listAuthors(): Response
    {
        return $this->render('author/list.html.twig', ['authors' => $this->authors]);
    }
    #[Route('/author/showDetails/{id}', name: 'authorDetails')]
    public function showDetails(int $id): Response
    {

        $author = $this->authors[$id];

        return $this->render('author/showDetails.html.twig', ['author' => $author]);
    }
  /* #[Route('/author/insertBd', name:'bd_insert')]
   public function insertBd(ManagerRegistry $manager): Response
   {
        $e = $manager->getManager();
        foreach($this->authors as $author){
            $newAuthor = new Author();
            $newAuthor->setUsername($author['username']);
            $newAuthor->setEmail($author['email']);
            $e->persist($newAuthor);
        }
        $e->flush();
        return new Response('Authors inserted');
   }*/
   #[Route('/author/showBd', name:'bd_show')]
    public function showBd(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();
        return $this->render('author/showBd.html.twig', ['authors' => $authors]);
    }
    #[Route('/author/new', name: 'author_new')]
    public function new(Request $request, ManagerRegistry $manager) : Response 
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $e = $manager->getManager();
            $e->persist($author);
            $e->flush();

            return $this->redirectToRoute('author_success');
        }
        return $this->render('author/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/author/success', name: 'author_success')]
    public function success() 
    {
        return new Response('author addes successfully');
    }
    #[Route('/author/delete/{id}', name: 'author_delete', methods: ['POST'])]
    public function delete(Request $request, Author $author, ManagerRegistry $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $e = $manager->getManager();
            $e->remove($author);
            $e->flush();
        }

        return $this->redirectToRoute('bd_show');
    }
    #[Route('/author/edit/{id}', name: 'author_edit')]
    public function edit(Request $request, Author $author, ManagerRegistry $manager) : Response 
    {
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $e = $manager->getManager();
            $e->flush();

            return $this->redirectToRoute('bd_show');
        }

        return $this->render('author/edit.html.twig', [
            'form' => $form->createView(),
            'author' => $author,
        ]);
    }
   
}
