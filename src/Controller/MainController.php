<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
       return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/custom/{name?}", name="custom")
     * @param Requrest $request
     * @return Response
     */

    public function custom(Request $request)
    {
     $name = $request->get('name');
        return $this->render('main/custom.html.twig',[
                'name' => $name,
        ]);
    }
}
