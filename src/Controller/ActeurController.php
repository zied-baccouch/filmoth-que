<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Form\ActeurType;
use App\Repository\ActeurRepository;
use App\Service\ActeurPDFService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/acteur')]
class ActeurController extends AbstractController
{
    #[Route('/', name: 'app_acteur_index', methods: ['GET'])]
    public function index(ActeurRepository $acteurRepository): Response
    {
        return $this->render('acteur/index.html.twig', [
            'acteurs' => $acteurRepository->findAll(),
        ]);
    }
    #[Route('/pdf/Acteur', name: 'app_acteur_pdf', methods: ['GET'])]
    public function generatePdfAllFilms(ActeurRepository $acteurRepository, ActeurPDFService $acteurPDFService): BinaryFileResponse
    {
        $acteurs = $acteurRepository->findAll();
        
        // Générer le contenu HTML pour tous les acteurs
        $html = $this->renderView('acteur/pdf.html.twig', [
            'acteurs' => $acteurs
        ]);
    
        // Générer le PDF
        $pdfFilePath = $acteurPDFService->generatePDF($html, 'all_acteurs.pdf');
    
        // Créer une réponse pour télécharger le fichier PDF
        $response = new BinaryFileResponse($pdfFilePath);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'all_acteurs.pdf'
        );
    
        return $response;
    }
    
    

    #[Route('/new', name: 'app_acteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $acteur = new Acteur();
        $form = $this->createForm(ActeurType::class, $acteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($acteur);
            $entityManager->flush();

            return $this->redirectToRoute('app_acteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('acteur/new.html.twig', [
            'acteur' => $acteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_acteur_show', methods: ['GET'])]
    public function show(Acteur $acteur): Response
    {
        return $this->render('acteur/show.html.twig', [
            'acteur' => $acteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_acteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Acteur $acteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActeurType::class, $acteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_acteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('acteur/edit.html.twig', [
            'acteur' => $acteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_acteur_delete', methods: ['POST'])]
    public function delete(Request $request, Acteur $acteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$acteur->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($acteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_acteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
