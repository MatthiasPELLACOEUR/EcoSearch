<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/moderator", name="moderator_")
 * 
 */
class ModeratorController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('moderator/index.html.twig', [
            'controller_name' => 'ModeratorController',
        ]);
    }
       /**
    * @Route("/posts/create", name="post_create")
    */
   public function createPost(Request $request): Response
   {
        $post = new Posts;
        
        $form = $this->createForm(PostsType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('moderator_home');
        }

        return $this->render('moderator/posts/create.html.twig', [
            'form' =>$form->createView()
        ]);
   }
}
