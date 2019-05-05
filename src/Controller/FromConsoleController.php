<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FromConsoleController extends AbstractController
{
    /**
     * @Route("/from/console", name="from_console")
     */
    public function index()
    {
        return $this->render('from_console/index.html.twig', [
            'controller_name' => 'FromConsoleController',
        ]);
    }
}
