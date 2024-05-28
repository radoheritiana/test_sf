<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    private $teamRepository;
    private $playerRepository;
    public function __construct(TeamRepository $teamRepository, PlayerRepository $playerRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->playerRepository = $playerRepository;
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $all_teams = $this->teamRepository->findAll();

        return $this->render('index.html.twig', [
            'all_teams' => $all_teams
        ]);
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
