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
    /**
     * @Route("/form/", name="form")
     */
    public function new(Request $request): Response
    {
        // создает объект задачи и инициализирует некоторые данные для этого примера
        $task = new Task();
//        $task->setTask('Write a blog post');
//        $task->setDueDate(new \DateTime('tomorrow'));
//        $form = $this->createFormBuilder($task)
//            ->add('task', TextType::class)
//            ->add('dueDate', DateType::class)
//            ->add('save', SubmitType::class, ['label' => 'Create Task'])
//            ->getForm();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $arr = [];

            foreach ($task as $valid => $val){
                $arr[] = [$valid => $val];
            }

            $buffer = fopen(__DIR__ . '/file.csv', 'a');
            fputs($buffer, ";");
            if(!is_file('file.csv')){
                $headers = ['name','email','password'];
                fputcsv($buffer, $headers, ';');
            }

            foreach ($arr as $val){
                fputcsv($buffer, $val,';');
            }
            fclose($buffer);

            return $this->redirectToRoute('form');
        }

        return $this->render('task/new.html.twig', ['form' => $form->createView()]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}