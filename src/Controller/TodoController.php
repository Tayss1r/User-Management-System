<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if(!$session->has('todos')) {
            $todos = [
                "lundi" => "je vais boire",
                "mardi" => "je joue le ballon",
                "mercredi" => "je voyage avec mes amies",
            ];
            $session->set('todos',$todos);
        }
        return $this->render('todo/index.html.twig');
    }
}
