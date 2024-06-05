<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WsGroupeUniteRepository;
use App\Repository\WsUniteRepository;
use App\Entity\WsUnite;
use App\Entity\WsSection;
use App\Entity\WsMembre;


class DashboardController extends AbstractDashboardController
{

    private $groupeUniteRepository;

    public function __construct(WsGroupeUniteRepository $groupeUniteRepository, WsUniteRepository $uniteRepository)
    {
        $this->groupeUniteRepository = $groupeUniteRepository;
        $this->uniteRepository = $uniteRepository;
    }


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $groupesData = $this->groupeUniteRepository->findAll();
        $labelCounts = [];

        foreach ($groupesData as $groupe) {
            $label = $groupe->getName();
            $id = $groupe->getId();

            if (!isset($labelCounts[$label])) {
                $labelCounts[$label] = ['count' => 0, 'id' => $id];
            }

            $unites = $groupe->getWsUnites();
            $labelCounts[$label]['count'] += $unites->count();
        }

        $labels = array_keys($labelCounts);
        $data = array_values($labelCounts);

        return $this->render('admin/dashboard.html.twig', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    #[Route('/admin/get-unite/{groupId}', name: 'get_unite')]
    public function getUnites(int $groupId, EntityManagerInterface $em): Response
    {
        try {
            $uniteRepo = $em->getRepository(WsUnite::class);
            $sectionRepo = $em->getRepository(WsSection::class);
            $membreRepo = $em->getRepository(WsMembre::class);

            $unites = $uniteRepo->findBy(['groupe' => $groupId]);

            if (!$unites) {
                throw $this->createNotFoundException('No units found for group ID ' . $groupId);
            }

            $unitesData = array_map(function ($unite) use ($sectionRepo, $membreRepo) {
                $sections = $sectionRepo->findBy(['unite' => $unite->getId()]);
                $totalMembers = 0;

                foreach ($sections as $section) {
                    $totalMembers += $membreRepo->count(['section' => $section->getId()]);
                }

                return [
                    'id' => $unite->getId(),
                    'name' => $unite->getName(),
                    'count' => $totalMembers,
                ];
            }, $unites);

            return new JsonResponse($unitesData);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }


    #[Route('/admin/get-section/{uniteName}', name: 'get_section')]
    public function getSection(string $uniteName, EntityManagerInterface $em): Response
    {
        try {
            $uniteRepo = $em->getRepository(WsUnite::class);
            $sectionRepo = $em->getRepository(WsSection::class);
            $membreRepo = $em->getRepository(WsMembre::class);

            // Trouver les unités par leur name
            $unites = $uniteRepo->createQueryBuilder('u')
                ->where('u.name LIKE :uniteName')
                ->setParameter('uniteName', $uniteName . '%')
                ->getQuery()
                ->getResult();

            if (!$unites) {
                return new JsonResponse(['error' => 'No unit found for name '.$uniteName], 404);
            }

            // Préparer les données des sections avec le comptage des membres
            $sectionsData = [];
            foreach ($unites as $unite) {
                $sections = $sectionRepo->findBy(['unite' => $unite->getId()]);
                foreach ($sections as $section) {
                    $membersCount = $membreRepo->count(['section' => $section->getId()]);
                    $sectionsData[] = [
                        'id' => $section->getId(),
                        'name' => $section->getName(),
                        'count' => $membersCount,
                    ];
                }
            }

            return new JsonResponse($sectionsData);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    #[Route('/admin/get-members/{sectionId}', name: 'get_members')]
    public function getMembers(int $sectionId, EntityManagerInterface $em): Response
    {
        try {
            $membreRepo = $em->getRepository(WsMembre::class);

            // Trouver les membres par section_id
            $members = $membreRepo->findBy(['section' => $sectionId]);

            if (!$members) {
                return new JsonResponse(['error' => 'No members found for section ID '.$sectionId], 404);
            }

            $membersData = array_map(function($member) {
                return [
                    'id' => $member->getId(),
                    'lastName' => $member->getNom(),
                    'firstName' => $member->getPrenom(),
                    'email' => $member->getEmail(),
                ];
            }, $members);

            return new JsonResponse($membersData);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="https://lesscouts.be/assets/logo.png" style="max-width:200px; " alt="Les Scouts"> ')
            ->renderContentMaximized();

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa-solid fa-home');
        yield MenuItem::linkToCrud('Rechercher', 'fa-solid fa-search', WsMembre::class);
    }
}
