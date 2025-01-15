<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TwigInheritanceController extends AbstractController
{
    #[Route('/twig/inheritance', name: 'app_twig_inheritance')]
    public function index(): Response
    {
        return $this->render('twig_inheritance/index.html.twig');
    }
}
