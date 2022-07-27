<?php

namespace App\Controller;

use App\Entity\Jeu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $em)
    {
        //return $this->redirectToRoute('admin');
        return $this->render('index.html.twig', [
            'jeux' => $em->getRepository(Jeu::class)->findBy([], ['nom' => 'ASC']),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('This should never be reached!');
    }


}
