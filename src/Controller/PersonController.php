<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PersonController extends AbstractController
{
    #[Route('/person', name: 'app_person')]
    public function AddPerson(ManagerRegistry $doctrine) {
        $entityManger = $doctrine->getManager();
        $person = new Person();
        $person->setFirstName('tayssir');
        $entityManger->persist($person);
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }
}
