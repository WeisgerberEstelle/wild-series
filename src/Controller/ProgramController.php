<?php

// src/Controller/ProgramController.php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

/**

 * @Route("/program", name="program_")

 */

class ProgramController extends AbstractController

{

    public function index(): Response

    {
        /**

         * @Route("/", name="index")

         */

        return $this->render('program/index.html.twig', [

            'website' => 'Wild Séries',

        ]);
    }

    /**

     * @Route("/show/{page}", methods={"GET"}, requirements={"page"="\d+"}, name="show")

     */

    public function show(int $page): Response

    {
        return $this->render('program/show.html.twig', [

            'page' => $page,
        ]);
    }
}
