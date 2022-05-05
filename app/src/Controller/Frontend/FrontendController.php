<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
class FrontendController extends AbstractController
{
    #[Route('/', name: 'app_frontend_frontend', methods: 'GET')]
    public function index(): Response
    {
        return $this->render('frontend/index.html.twig');
    }
}
