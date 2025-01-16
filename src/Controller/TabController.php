<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb<\d+>?5}', name: 'app_tab')]
    public function index($nb): Response
    {
        $score = [];
        for ($i = 0 ; $i<$nb; $i++) {
            $score[] = rand(0, 20);
        }
        return $this->render('tab/index.html.twig',  ['lastname' => 'ferhi','firstname' => 'tayssir', 'score' => $score]);
    }
    #[Route('/tab/employees', 'app_emp')]
    public function Employee(): Response
    {
        $people = [
            [
                "firstname" => "John",
                "lastname" => "Doe",
                "age" => 30
            ],
            [
                "firstname" => "Jane",
                "lastname" => "Smith",
                "age" => 25
            ],
            [
                "firstname" => "Alice",
                "lastname" => "Johnson",
                "age" => 28
            ]
        ];
        return $this->render('tab/users.html.twig',  ['people' => $people]);
    }
}
