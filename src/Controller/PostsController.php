<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use App\Repository\PostsRepository;
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
     * @Route("/", name="list", methods={"GET"})
     */
    public function index(PostsRepository $postsRepository, Request $request): Response
    {
        // On définit le nombre d'élément par page
        $limit = 4;

        // On récupère le numéro de page
        $page = (int)$request->query->get('page', 1);

        // On récupère les posts de la page
        $posts = $postsRepository->getPaginatedPosts($page, $limit);

        // On récupère le nombre total de posts
        $total = $postsRepository->getTotalPosts();

        foreach($posts as $i => $post) {
            $posts[$i]->setContent(substr($post->getContent(), 0, 255));
        }

        return $this->render('posts/index.html.twig', compact('posts', 'total', 'limit', 'page'));
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if($this->getUser()->getIsModerator() == 1){

            $post = new Posts();
            $post->setCreator($this->getUser());

            $form = $this->createForm(PostsType::class, $post);

            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($post);
                $entityManager->flush();
                
                return $this->redirectToRoute('list');
            }

            return $this->render('posts/new.html.twig', [
                'postForm' => $form->createView(),
                ]);
        }
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Posts $post): Response
    {
        return $this->render('posts/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Posts $post): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('posts_index');
        }

        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Posts $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('posts_index');
    }
}
