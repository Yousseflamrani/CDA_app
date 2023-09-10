<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AffaireRepository;
use App\Repository\UserRepository;
use App\Service\SessionManagementService;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(AffaireRepository $affaireRepository, UserRepository $userRepository): Response
    {


       


        //BarChart
        $statuses = ['ouvert', 'fermer', 'annuler'];
        $backgroundColors = ['rgb(255, 99, 132,0.7)', 'rgb(54, 162, 235,0.7)', 'rgb(75, 192, 192,0.7)'];

        $datasets = [];
        foreach ($statuses as $index => $status) {
            $data = array_fill(0, count($statuses), 0);  // Crée un tableau rempli de zéros
            $data[$index] = $affaireRepository->countStatut($status);  

            $datasets[] = [
                'label' => ucfirst($status),
                'backgroundColor' => $backgroundColors[$index],
                'data' => $data
            ];
        }

        // Doughnut & Pie chart 
        $sections = ['voie', 'tracé', 'OTH', 'GAB'];
        $backgroundColorsSections = ['rgb(255, 205, 86, 0.7)', 'rgb(153, 102, 255, 0.7)', 'rgb(255, 159, 64, 0.7)', 'rgb(201, 203, 207, 0.7)'];

        $sectionData = [];
        foreach ($sections as $section) {
            $sectionData[] = $affaireRepository->countBySection($section);
        }

        $affairesBySection = [
            'data' => $sectionData,
            'backgroundColor' => $backgroundColorsSections,
            'label' => 'Affaires par section'
        ];

        $affaireCount = count($affaireRepository->findAll());
        $userCount = count($userRepository->findAll());

        return $this->render('home/index.html.twig', [
            'controller_name' => 'ChartController',
            'affaireCount' => $affaireCount,
            'userCount' => $userCount,
            'datasets' => $datasets,
            'affairesBySection' => $affairesBySection,
            'statuses' => $statuses,
            'sections' => $sections
        ]);
    }
}
