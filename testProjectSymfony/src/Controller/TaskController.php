<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\Type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskController extends AbstractController
{
    const FILENAME = '/file.csv';
    const DELIMITER = ';';

    /**
     * @Route("/tasks/", name="tasks")
     */

    public function createFile(Request $request): Response
    {
        $task = new Task();
        $createTaskForm = $this->createForm(TaskType::class, $task);

        $createTaskForm->handleRequest($request);

        if ($createTaskForm->isSubmitted() && $createTaskForm->isValid()) {
            $tasks = $createTaskForm->getData();
            $dataUser = [];

            foreach ($tasks as $valid => $val){
                $dataUser[] = [$valid => $val];
            }

            $tasksFile = fopen(__DIR__ . TaskController::FILENAME , 'a');

            if(!file_get_contents(__DIR__ . TaskController::FILENAME)){
                fputs($tasksFile, TaskController::DELIMITER);
                $headers = ['name','email','password'];
                fputcsv($tasksFile, $headers, TaskController::DELIMITER);
            }

            foreach ($dataUser as $val){
                fputcsv($tasksFile, $val,TaskController::DELIMITER);
            }
            fclose($tasksFile);

            return $this->redirectToRoute('tasks');
        }

        return $this->render('task/createFile.html.twig', ['form' => $createTaskForm->createView()]);
    }
}