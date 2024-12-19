<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Enum\Module;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        $htmlContent = file_get_contents('../src/Views/cours/index.html');
        return new Response($htmlContent);
    }

    #[Route('api/cours', name: 'api_cours')]
    public function getCours(Request $request, CoursRepository $coursRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 2);
        $offset = ($page - 1) * $limit;
        $totalCours = $coursRepository->count();
        $cours = $coursRepository->findBy([], null, $limit, $offset);
         
        $data = [
            'cours' => array_map(function ($cour) {
                return [
                    'id' => $cour->getId(),
                    'nomCours' => $cour->getNom(),
                    'module' => $cour->getModule(),
                ];
            }, $cours),
            'pagination' => [
                'current_page' => $page,
                'total_pages' => ceil($totalCours / $limit),
                'totalCours' => $totalCours,
            ]
        ];

        
        return new JsonResponse($data);
    }

    #[Route('/api/cours/store', name: 'api_cours.store', methods: ['post'])]
    public function store(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $cours = new Cours();
        $cours->setNom($request->request->get('nom'));
        $module = Module::getValue($request->request->get('module'));
        $cours->setModule($module);
        $cours->setProfesseur($request->request->get('professeur'));
        $entityManager->persist($cours);
        $entityManager->flush();
        return $this->json([
            'message' => 'Payement created successfully',
            'path' => 'src/Controller/PayementController.php',
        ]);

    }

    #[Route('/cours/form', name: 'api_cours')]
    public function form(): Response
    {
        $htmlContent = file_get_contents('../src/Views/cours/form.html');
        return new Response($htmlContent);
    }


}
