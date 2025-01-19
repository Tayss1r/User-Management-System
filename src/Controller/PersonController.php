<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/person')]
class PersonController extends AbstractController
{
    #[Route('/', name: 'findAll.person')]
    public function index(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Person::class);
        $persons = $repository->findAll();
        return $this->render('person/index.html.twig', ['persons' => $persons]);
    }


    #[Route('/add', name: 'app_person')]
    public function AddPerson(ManagerRegistry $doctrine) {

        $entityManger = $doctrine->getManager();

        $person = new Person();
        $person->setFirstName('Tayssir');
        $person->setLastname('Ferhi');
        $person->setAge(20);

        $entityManger->persist($person);

        $entityManger->flush();
        return $this->render('person/detail.html.twig', [
            'person' => $person,
        ]);
    }
}
