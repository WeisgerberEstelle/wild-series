<?php

// src/Controller/ProgramController.php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use App\Form\ProgramType;

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

/**

 * @Route("/program", name="program_")

 */

class ProgramController extends AbstractController

{
    /**

     * Show all rows from Program’s entity

     *

     * @Route("/", name="index")

     * @return Response A response instance

     */
    public function index(): Response

    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();


        return $this->render('program/index.html.twig', [

            'programs' => $programs

        ]);
    }
    
    /**

     * @Route("/new", name="new")

     */

    public function new(Request $request) : Response

    {
        $program = new Program();

        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
        
            $entityManager->persist($program);

            $entityManager->flush();

            return $this->redirectToRoute('program_index');
    
        }

        return $this->render('program/new.html.twig', [

            "form" => $form->createView(),

        ]);

    }

    /**

     * Getting a program by id

     *

     * @Route("/{id<^[0-9]+$>}", name="show")

     * @return Response

     */

    public function show(Program $program): Response

    {
        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program' => $program], ['number' => 'ASC']);

        if (!$program) {
            throw $this->createNotFoundException(

                'No program with id found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [

            'program' => $program, 'seasons' => $seasons

        ]);
    }

    /**

     * @Route("/{program}/season/{season}", name="season_show")

     * @return Response

     */

    public function showSeason(Program $program, Season $season)
    {

        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season]);
    }

    /**
     * @Route("/{program}/season/{season}/episode/{episode}", name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode):Response
    {

        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode'=> $episode]);
    }
}
