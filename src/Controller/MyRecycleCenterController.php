<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyRecycleCenterController extends AbstractController
{
    /**
     * @Route("/my_recycle_center", name="my_recycle_center")
     */
    public function index(): Response
    {
        $apiKey = 'AIzaSyBpOMrJVx49tkFhCFND4bsarPHxDJXj7os';
        
        return $this->render('my_recycle_center/index.html.twig', [
            'apiKey' => $apiKey,
        ]);
    }
}
