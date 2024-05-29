<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Team;
use App\Form\PlayerFormType;
use App\Form\TeamFormType;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {

        //team pagination
        $dql   = "SELECT t FROM App\Entity\Team t";
        $query = $em->createQuery($dql);

        $paginate_teams = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        //player pagination
        $dql   = "SELECT p FROM App\Entity\Player p";
        $query = $em->createQuery($dql);

        $paginate_players = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('index.html.twig', [
            'all_teams' => $paginate_teams,
            'all_players' => $paginate_players
        ]);
    }

    #[Route('/add-team-player', name: 'app_create_team')]
    public function add_team_and_player(Request $request, EntityManagerInterface $em): Response
    {
        // handle create team
        $team = new Team();
        $team_form = $this->createForm(TeamFormType::class, $team);
        $team_form->handleRequest($request);

        if ($team_form->isSubmitted() && $team_form->isValid()) {
            $em->persist($team);
            $em->flush();
            return $this->redirectToRoute('app_index');
        }

        //handle create player
        $player = new Player();
        $player_form = $this->createForm(PlayerFormType::class, $player);
        $player_form->handleRequest($request);

        if ($player_form->isSubmitted() && $player_form->isValid()) {
            $em->persist($player);
            $em->flush();
            return $this->redirectToRoute('app_index');
        }

        return $this->render('add_team_and_player.html.twig', [
            'team_form' => $team_form,
            'player_form' => $player_form
        ]);
    }

    #[Route('/buy-sell-player', name: 'app_buy_or_sell_player')]
    public function buy_or_sell_player(): Response
    {

        return $this->render('buy_or_sell_player.html.twig', []);
    }
}
