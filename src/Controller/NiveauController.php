<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class NiveauController extends AbstractController
{
    #[Route('/niveaux', name: 'niveaux.index')]
    public function index(): Response
    {
        $htmlContent = file_get_contents('../src/Views/niveaux/index.html');
        return new Response($htmlContent);
    }

    #[Route('api/niveaux', name: 'api_niveaux')]
    public function getNiveau(Request $request, SerializerInterface $serializer, NiveauRepository $niveauRepository):   Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 2);
        $offset = ($page - 1) * $limit;
        $totalNiveau = $niveauRepository->count();
        $niveaux = $niveauRepository->findBy([], ['id' => 'Asc'], $limit, $offset);
        $data = [
            'niveaux' => array_map(function ($niveau) {
                return [
                    'id' => $niveau->getId(),
                    'nom' => $niveau->getNom(),
                ];
            }, $niveaux),
            'pagination' => [
                'current_page' => $page,
                'totalPages' => ceil($totalNiveau / $limit),
                'totalNiveau' => $totalNiveau,
            ]
        ];
        return new JsonResponse($data);

    }

    #[Route('/niveaux/form', name: 'niveaux.form')]
    public function form(): Response
    {
        $htmlContent = file_get_contents('../src/Views/niveaux/form.html');
        return new Response($htmlContent);
    }

    #[Route('/api/niveaux/store', name: 'api_niveaux.store', methods: ['post'])]
    public function store(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $niveau = new Niveau();
        $niveau->setNom($request->request->get('nom'));
        $entityManager->persist($niveau);
        $entityManager->flush();
        return $this->json([
            'message' => 'Payement created successfully',
            'path' => 'src/Controller/PayementController.php',
        ]);

    }
}
