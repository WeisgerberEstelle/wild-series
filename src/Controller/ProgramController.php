<?php

// src/Controller/ProgramController.php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\ProgramType;
use App\Service\Slugify;
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

    public function new(Request $request, Slugify $slugify, MailerInterface $mailer): Response

    {
        $program = new Program();

        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($program->getTitle());

            $program->setSlug($slug);

            $entityManager->persist($program);

            $entityManager->flush();

            
            $email = (new Email())

                ->from($this->getParameter('mailer_from'))

                ->to('akumaony@gmail.com')

                ->subject('Une nouvelle série vient d\'être publiée !')

                ->html($this->renderView('program/newProgramEmail.html.twig', ['program' => $program]));


        $mailer->send($email);

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [

            "form" => $form->createView(),

        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})

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

            'program' => $program, 'seasons' => $seasons,

        ]);
    }

    /**
     * @Route("/{slug}/edit", name="program_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Program $program, Slugify $slugify, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $entityManager->flush();

            return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Program $program, EntityManagerInterface $entityManager): Response
    {

        if ($this->isCsrfTokenValid('delete' . $program->getId(), $request->request->get('_token'))) {
            $entityManager->remove($program);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
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
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {

        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]);
    }
}
