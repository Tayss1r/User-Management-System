<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/person')]
class PersonController extends AbstractController
{
    // list
    #[Route('/', name: 'findAll.person')]
    public function index(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Person::class);
        $persons = $repository->findAll();
        return $this->render('person/index.html.twig', ['persons' => $persons]);
    }

    // list with pagination
    #[Route('/all/{page?1}/{num?12}', name: 'all.person')]
    public function indexAll(ManagerRegistry $doctrine, $page, $num): Response {
        $repository = $doctrine->getRepository(Person::class);
        $numPers = $repository->count([]);
        $numPage = ceil($numPers / $num);
        $persons = $repository->findBy([], [], $num, ($page-1) * $num);
        return $this->render('person/index.html.twig', [
            'persons' => $persons,
            'numPage' => $numPage,
            'page' => $page,
            'num' => $num
        ]);
    }

    // add a person to the list
    #[Route('/add', name: 'app_person')]
    public function AddPerson(ManagerRegistry $doctrine): Response {

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

    // see the details of someone
    #[Route('/{id<\d+>}', name: 'detail.person')]
    public function detail(Person $person = null): Response {

        if(!$person) {
            $this->addFlash('error', "this person doesn't exist");
            return $this->redirectToRoute('findAll.person');
        }
        return $this->render('person/detail.html.twig', ['person' => $person]);
    }

    // delete someone
    #[Route('/delete/{id}', 'delete.person')]
    public function delete(Person $person = null, ManagerRegistry $doctrine): RedirectResponse{
        if($person) {
            $manager = $doctrine->getManager();
            $manager->remove($person);
            $manager->flush();
            $this->addFlash('success', "the person has been deleted successfully");
        } else {
            $this->addFlash('error', "this person does not exist");
        }
        return $this->redirectToRoute('all.person');
    }
}
