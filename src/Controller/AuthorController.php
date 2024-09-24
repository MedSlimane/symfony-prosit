<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    public $authors = array(
        1 => array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
        2 => array('id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200),
        3 => array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
    );
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
}
