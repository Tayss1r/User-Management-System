<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig',  ['lastname' => 'ferhi','firstname' => 'tayssir']);
    }
    #[Route('/template', name: 'app_template')]
    public function template(): Response
    {
        return $this->render('Template.html.twig');
    }

    #[Route("/multi/{a}/{b}","app_multi")]
    public function multiplication($a, $b) {
        $result = $a * $b;
        return new Response("<h1>$result</h1>");
    }

    public function sayHello(Request $request, $firstname, $lastname) {
        return $this->render('first/hello.html.twig',  ['lastname' => $lastname,'firstname' => $firstname]);
    }

}

/*
    #[Route("/multi/{a}/{b}","app_multi", requirements: ['a' => '\d+'], 'b' => '\d+'])]
    #[Route("/multi/{a<\d+>}/{b<\d+>}","app_multi")]
        -> the values of a and b must be an integer

 */