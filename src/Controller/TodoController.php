<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if(!$session->has('todos')) {
            $todos = [
                "monday" => "study",
                "thuesday" => "go to the gym",
                "wednesday" => "go out with friends",
            ];
            $session->set('todos',$todos);
            $this->addFlash('info', "todo list has been initialised");
        }
        return $this->render('todo/index.html.twig');
    }
    #[Route('/todo/add/{name}/{contenu}','add.todo')]
    public function addTodo(Request $request, $name, $contenu): RedirectResponse {
        $session = $request->getSession();
        if($session->has('todos')) {
            $todos = $session->get('todos');
            if(isset($todos[$name])) {
                $this->addFlash('error',"todo already exist");
            } else {
                $todos[$name] = $contenu;
                $session->set('todos',$todos);
                $this->addFlash('success',"the todo has been added succesfully");
            }
        } else {
            $this->addFlash('error', "the todo list doesn't exist");
        }
        return $this->redirectToRoute('todo');
    }
    #[Route('/todo/update/{name}/{contenu}','update.todo')]
    public function updateTodo(Request $request, $name, $contenu): RedirectResponse {
        $session = $request->getSession();
        if($session->has('todos')) {
            $todos = $session->get('todos');
            if(!isset($todos[$name])) {
                $this->addFlash('error',"todo doesn't exist");
            } else {
                $todos[$name] = $contenu;
                $session->set('todos',$todos);
                $this->addFlash('success',"the todo has been modified succesfully");
            }
        } else {
            $this->addFlash('error', "the todo list doesn't exist");
        }
        return $this->redirectToRoute('todo');
    }
    #[Route('/todo/delete/{name}','delete.todo')]
    public function deleteTodo(Request $request, $name): RedirectResponse {
        $session = $request->getSession();
        if($session->has('todos')) {
            $todos = $session->get('todos');
            if(!isset($todos[$name])) {
                $this->addFlash('error',"todo doesn't exist");
            } else {
                unset($todos[$name]);
                $session->set('todos',$todos);
                $this->addFlash('success',"the todo has been deleted succesfully");
            }
        } else {
            $this->addFlash('error', "the todo list doesn't exist");
        }
        return $this->redirectToRoute('todo');
    }
    #[Route('/todo/reset','reset.todo')]
    public function resetTodo(Request $request): RedirectResponse {
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('todo');
    }

}
