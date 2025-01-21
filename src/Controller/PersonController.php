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

    #[Route('/all/{page?1}/{num?12}', name: 'all.person')]
    public function indexAll(ManagerRegistry $doctrine, $page, $num): Response {
        $repository = $doctrine->getRepository(Person::class);
        $persons = $repository->findBy([], [], $num, ($page-1) * $num);
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



    #[Route('/{id<\d+>}', name: 'detail.person')]
    public function detail(Person $person = null): Response {

        if(!$person) {
            $this->addFlash('error', "this person doesn't exist");
            return $this->redirectToRoute('findAll.person');
        }
        return $this->render('person/detail.html.twig', ['person' => $person]);
    }
}
