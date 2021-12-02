<?php

// src/Controller/ProgramController.php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Program;
use App\Entity\Season;

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

     * Getting a program by id

     *

     * @Route("/show/{id<^[0-9]+$>}", name="show")

     * @return Response

     */

    public function show(int $id): Response

    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);

        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program' => $program], ['number' => 'ASC']);

        if (!$program) {
            throw $this->createNotFoundException(

                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [

            'program' => $program, 'seasons' => $seasons

        ]);
    }

    /**

     * @Route("/{programId}/season/{seasonId}", name="season_show")

     * @return Response

     */

    public function showSeason(int $programId, int $seasonId)
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $programId]);

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $seasonId, 'program' => $program]);

            return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season]);
        
    }
}
