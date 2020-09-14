<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\TasksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/tasks")
 */
class TasksController extends AbstractController
{
    private TasksRepository $projectRepository;
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
     * @Route("/", name="tasks_index", methods={"GET"})
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

    // /**
    //  * @Route("/new", name="tasks_new", methods={"GET","POST"})
    //  */
    // public function new(Request $request): Response
    // {
    //     $task = new Tasks();
    //     $form = $this->createForm(TasksType::class, $task);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($task);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('tasks_index');
    //     }

    //     return $this->render('tasks/new.html.twig', [
    //         'task' => $task,
    //         'form' => $form->createView(),
    //     ]);
    // }

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
     * @Route("/{id}/edit", name="tasks_edit", methods={"GET","POST"})
     */
    // public function edit(Request $request, Tasks $task): Response
    // {
    //     $form = $this->createForm(TasksType::class, $task);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('tasks_index');
    //     }

    //     return $this->render('tasks/edit.html.twig', [
    //         'task' => $task,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/{id}", name="tasks_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tasks $task): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tasks_index');
    }
}
