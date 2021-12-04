<?php 

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/actor", name="actor_")
 */
class ActorController extends AbstractController
{
    /**

     * @Route("/{id<^[0-9]+$>}", name="show")

     * @return Response

     */

    public function show(Actor $actor): Response

    {
        return $this->render('actor/show.html.twig', [

            'actor' => $actor]);
    }

}