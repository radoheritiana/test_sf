<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index.html.twig', []);
    }

    #[Route('/add-team-player', name: 'app_create_team')]
    public function add_team_and_player(): Response
    {
        return $this->render('add_team_and_player.html.twig', []);
    }

    #[Route('/buy-sell-player', name: 'app_buy_or_sell_player')]
    public function buy_or_sell_player(): Response
    {
        return $this->render('buy_or_sell_player.html.twig', []);
    }
}
