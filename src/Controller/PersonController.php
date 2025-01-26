<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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

    #[Route('/age/{min}/{max}', name: 'ageInterval.person')]
    public function ageByInterval(ManagerRegistry $doctrine, $min, $max): Response {
        $repository = $doctrine->getRepository(Person::class);
        $persons = $repository->findByAge($min, $max);
        return $this->render('person/index.html.twig', ['persons' => $persons]);
    }

    #[Route('/stats/age/{min}/{max}', name: 'stats.person')]
    public function statsPersonByInterval(ManagerRegistry $doctrine, $min, $max): Response {
        $repository = $doctrine->getRepository(Person::class);
        $stats = $repository->statsPersonByAgeInterval($min, $max);
        return $this->render('person/stats.html.twig', [
            'stats' => $stats[0],
            'min' =>$min,
            'max' =>$max
        ]);
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
            'num' => $num,
            'isPaginated' => true
        ]);
    }

    // add a person using forms
    #[Route('/add', name: 'app_person')]
    public function addPerson(ManagerRegistry $doctrine, Request $request): Response {


        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->remove('createdAt');
        $form->remove('updatedAt');

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $manager = $doctrine->getManager();
            $manager->persist($person);
            $manager->flush();
            $this->addFlash('success', "the person as been added sucessfully");
            return $this->redirectToRoute('all.person');
        }

        return $this->render('person/addPerson.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // edit a person using forms
    #[Route('/edit{id?0}', name: 'edit.person')]
    public function editPerson(Person $person = null, ManagerRegistry $doctrine, Request $request): Response {

        if (!$person) {
            $person = new Person();
        }

        $form = $this->createForm(PersonType::class, $person);
        $form->remove('createdAt');
        $form->remove('updatedAt');

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $manager = $doctrine->getManager();
            $manager->persist($person);
            $manager->flush();
            $this->addFlash('success', "the person as been edited sucessfully");
            return $this->redirectToRoute('all.person');
        }

        return $this->render('person/addPerson.html.twig', [
            'form' => $form->createView(),
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

    #[Route('/update/{id}/{firstname}/{lastname}/{age}', 'person.update')]
    public function update(Person $person = null,ManagerRegistry $doctrine, $firstname, $lastname, $age ): Response {


        if($person) {
            $person->setFirstName($firstname);
            $person->setLastname($lastname);
            $person->setAge($age);
            $manager = $doctrine->getManager();

            $manager->persist($person);

            $manager->flush();
            $this->addFlash('success', "the person's info has been modified successfully");

        } else {
            $this->addFlash('error', "this person does not exist");
        }
        return $this->redirectToRoute('all.person');
    }
}
