<?php

namespace App\Controller;
//use Symfony\Component\HttpFoundation\Response;
use App\GreetingGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

//class DefaultController
//{
//    /**
//     * @Route("/hello/{name}")
//     */
//    public function index($name)
//    {
//        return new Response("Hello $name!");
//    }
//
//    /**
//     * @Route("/simplicity")
//     */
//    public function simple()
//    {
//        return new Response('Simple! Easy! Great!');
//    }
//}
class DefaultController extends AbstractController
{
    /**
     * @Route("/hello/{name}")
    */
    //public function index($name, LoggerInterface $logger, GreetingGenerator $generator)
    public function index($name, GreetingGenerator $generator)
    {
        $greeting = $generator->getRandomGreeting();
        //$logger->info("Saying $greeting to $name!");
        return $this->render('default/index.html.twig', ['name' => $name, 'greeting' => $greeting]);
    }

    /**
     * @Route("/api/hello/{name}")
    */
    public function apiExample($name)
    {
        return $this->json(['name' => $name, 'symfony' => 'rocks']);
    }
}