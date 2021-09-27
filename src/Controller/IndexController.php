<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * 
     */
    public function index() 
    {
        
        return new response($this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]));
        
       
    }
}
