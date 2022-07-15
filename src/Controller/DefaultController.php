<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index()
    {
        //return new Response('<h1>❤️</h1>');
        return $this->redirectToRoute('admin');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('This should never be reached!');
    }


}
