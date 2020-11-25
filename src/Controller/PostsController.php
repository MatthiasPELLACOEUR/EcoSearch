<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Repository\PostsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/posts", name="posts_")
     */

class PostsController extends AbstractController
{
     
    /**
    * @Route("/", name="list")
    */

    public function index(PostsRepository $postsRepo, Request $request): Response
    {
        // On définit le nombre d'élément par page
        $limit = 6;

        // On récupère le numéro de page
        $page = (int)$request->query->get('page', 1);
        
        // On récupère les posts de la page
        $posts = $postsRepo->getPaginatedPosts($page, $limit);

        // On récupère le nombre total de posts
        $total = $postsRepo->getTotalPosts();

        foreach($posts as $i => $post) {
            $posts[$i]->setContent(substr($post->getContent(), 0, 255));
        }

        return $this->render('posts/index.html.twig', compact('posts', 'total', 'limit', 'page'));
    }
}
