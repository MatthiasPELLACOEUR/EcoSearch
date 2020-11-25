<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {

        $em = $this->getDoctrine()
            ->getRepository(Posts::class);
        $posts = $em->findBy(array(), array('id' => 'DESC'),4);
        

        foreach($posts as $i => $post) {
            $posts[$i]->setContent(substr($post->getContent(), 0, 255));
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'posts' => $posts,
        ]);
    }
}
