<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
class DefaultController extends AbstractController

{
    /**

     * @Route("/", name="app_index")

     */
    public function index(): Response

    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('index.html.twig', ['programs' => $programs]);
    }
}
