<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Sale;
use App\Entity\Team;
use App\Form\PlayerFormType;
use App\Form\SalesFormType;
use App\Form\TeamFormType;
use App\Repository\SaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {
        //team pagination
        $dql   = "SELECT t FROM App\Entity\Team t";
        $query = $em->createQuery($dql);

        $paginate_teams = $paginator->paginate(
            $query,
            $request->query->getInt('t_page', 1),
            5,
            [
                'pageParameterName' => 't_page',
                'sortFieldParameterName' => 't_sort',
                'sortDirectionParameterName' => 't_direction'
            ]
        );

        //player pagination
        $dql   = "SELECT p FROM App\Entity\Player p";
        $query = $em->createQuery($dql);

        $paginate_players = $paginator->paginate(
            $query,
            $request->query->getInt('p_page', 1),
            5,
            [
                'pageParameterName' => 'p_page',
                'sortFieldParameterName' => 'p_sort',
                'sortDirectionParameterName' => 'p_direction'
            ]
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
    public function buy_or_sell_player(Request $request, SaleRepository $saleRepository, EntityManagerInterface $em): Response
    {
        $sale = new Sale();
        $sales_form = $this->createForm(SalesFormType::class, $sale);

        $sales_form->handleRequest($request);

        if ($sales_form->isSubmitted() && $sales_form->isValid()) {

            // on transfert le joueur ves l'équipe acheteur
            $sale->getPlayer()->setTeam($sale->getBuyer());
            // on ajoute le montant de transfert au solde de l'équipe vendeur
            $sale->getSeller()->setBalance($sale->getSeller()->getBalance() + $sale->getAmount());
            // on déduit le montant de transfert au solde de l'équipe acheteur
            $sale->getBuyer()->setBalance($sale->getBuyer()->getBalance() - $sale->getAmount());

            $em->persist($sale);
            $em->flush();
            return $this->redirectToRoute('app_buy_or_sell_player');
        }

        $all_mercato = $saleRepository->findAll();
        return $this->render('buy_or_sell_player.html.twig', [
            'sales_form' => $sales_form,
            'all_mercato' => $all_mercato
        ]);
    }
}
