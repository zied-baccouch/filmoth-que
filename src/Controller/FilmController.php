<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use App\Service\PDFService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchType;
use App\Model\SearchData;

#[Route('/film')]
class FilmController extends AbstractController
{
    #[Route('/', name: 'app_film_index', methods: ['GET'])] // Correction de l'URL
    public function index(Request $request, FilmRepository $filmRepository): Response
    {
        // Obtenez la liste des films depuis le repository
        $films = $filmRepository->findAll();

        // Rendez le template en passant la liste des films
        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }

    #[Route('/pdf/all', name: 'app_film_pdf_all', methods: ['GET'])]
    public function generatePdfAllFilms(FilmRepository $filmRepository, PDFService $pdfService): BinaryFileResponse
    {
        $films = $filmRepository->findAll();
        
        $html = $this->renderView('film/pdf.html.twig', [
            'films' => $films
        ]);
    
        $pdfFilePath = $pdfService->generatePDF($html, 'all_films.pdf');
    
        $response = new BinaryFileResponse($pdfFilePath);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'all_films.pdf'
        );
    
        return $response;
    }
    
    #[Route('/new', name: 'app_film_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($film);
            $entityManager->flush();

            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('film/new.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_film_show', methods: ['GET'])]
    public function show(Film $film): Response
    {
        return $this->render('film/show.html.twig', [
            'film' => $film,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_film_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('film/edit.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_film_delete', methods: ['POST'])]
    public function delete(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$film->getId(), $request->request->get('_token'))) {
            $entityManager->remove($film);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/search', name: 'app_film_search', methods: ['GET', 'POST'])]
    public function search(Request $request, FilmRepository $filmRepository): Response
    {
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        $films = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $films = $filmRepository->findBySearchData($searchData);

            if (count($films) === 1) {
                $filmId = $films[0]->getId();
                return $this->redirectToRoute('app_film_show', ['id' => $filmId]);
            }
        }

        return $this->render('film/search.html.twig', [
            'form' => $form->createView(),
            'films' => $films,
        ]);
    }

    #[Route('/stats', name: 'app_film_stats', methods: ['GET'])]
    public function statistiques(FilmRepository $filmRepository): Response
    {
        $filmCountsByCategory = $filmRepository->countFilmsByCategory();
        
        $categories = [];
        $counts = [];
        
        foreach ($filmCountsByCategory as $data) {
            $categories[] = $data['design_categorie'];
            $counts[] = $data['film_count'];
        }

        return $this->render('film/stats.html.twig', [
            'categories' => json_encode($categories),
            'counts' => json_encode($counts),
        ]);
    }
}
