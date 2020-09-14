<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Form\TasksType;
use App\Repository\TasksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TasksController extends AbstractController
{
    private TasksRepository $tasksRepository;
    private EntityManagerInterface $em;
    /**
     * TasksController constructor.
     */
    public function __construct(TasksRepository $tasksRepository, EntityManagerInterface $em)
    {
        $this->tasksRepository = $tasksRepository;
        $this->em = $em;
    }
    
    /**
     * @Route("/tasks", name="tasks_index", methods={"GET"})
     */
    public function index(TasksRepository $tasksRepository): Response
    {
        return $this->render('tasks/index.html.twig', [
            'tasks' => $tasksRepository->findAll(),
        ]);
    }

    /**
     * @Route("/tâche/{idTasks}/edition",
     *     name="tasks_edit",
     *     options={"expose": true},
     *     methods={"GET","POST","PUT"},
     *     requirements={"idTasks" : "\d+"})
     * @Entity("tasks", expr="repository.findId(idTasks)")
     * @param Tasks $tasks
     * @param Request $request
     * @return Response
     */
    public function edit(Project $tasks,Request $request):Response{

        $idTasks = $tasks->getId() === null ? 0: $tasks->getId();
        $form = $this->createForm(ProjectType::class, $tasks,["action"=>$this->generateUrl("_tasks_edit",["idTasks"=>$idTasks])]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($tasks);
            $this->em->flush();
            return $this->redirectToRoute('_tasks');

        }else{
            return $this->render('tasks/tasks-edit.html.twig', ["form"=>$form->createView()]);
        }

    }

    /**
     * @Route("/{id}", name="tasks_show", methods={"GET"})
     */
    public function show(Tasks $task): Response
    {
        return $this->render('tasks/show.html.twig', [
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{idTask}/suppression",
     *     name="_task_remove",
     *     options={"expose": true},
     *     methods={"DELETE"},
     *     requirements={"idTask" : "\d+"})
     * @Entity("task", expr="repository.findId(idTask)")
     * @param Tasks $task
     * @return JsonResponse
     */
    public function remove(Tasks $task): JsonResponse
    {
        $this->em->remove($task);
        $this->em->flush();

        return $this->json(true);
    }
}
