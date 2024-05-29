<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamFormType;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    private TeamRepository $teamRepository;
    private PlayerRepository $playerRepository;
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
    public function add_team_and_player(Request $request, EntityManagerInterface $em): Response
    {
        $team = new Team();
        $team_form = $this->createForm(TeamFormType::class, $team);
        $team_form->handleRequest($request);

        if ($team_form->isSubmitted() && $team_form->isValid()) {
            $em->persist($team);
            $em->flush();
            return $this->redirectToRoute('app_index');
        }
        return $this->render('add_team_and_player.html.twig', [
            'team_form' => $team_form
        ]);
    }

    #[Route('/buy-sell-player', name: 'app_buy_or_sell_player')]
    public function buy_or_sell_player(): Response
    {

        return $this->render('buy_or_sell_player.html.twig', []);
    }
}
