<?php

namespace App\Controller;

use App\Entity\Attestation;
use App\Entity\Convention;
use App\Entity\Etudiant;
use App\Form\AttestationType;
use App\Repository\AttestationRepository;
use App\Repository\ConventionRepository;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\Mapping\Id;
use FTP\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attestation")
 */
class AttestationController extends AbstractController
{
    /**
     * @Route("/", name="app_attestation_index", methods={"GET"})
     */
    public function index(AttestationRepository $attestationRepository): Response
    {
        return $this->render('attestation/index.html.twig', [
            'attestations' => $attestationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_attestation_new", methods={"GET"})
     */
    public function new(Request $request, AttestationRepository $attestationRepository, EtudiantRepository $etudiantRepository): Response
    {
        $attestation = new Attestation();
        $etudiant = $etudiantRepository->findAll();
        
        
        
        

        return $this->renderForm('attestation/new.html.twig', [
            'etudiants' => $etudiant,
            'attestation' => $attestation,
            
        ]);
    }

    /**
     * @Route("/new", name="app_attestation_newPost", methods={"POST"})
     */
    public function newPost(Request $request, AttestationRepository $attestationRepository, EtudiantRepository $etudiantRepository, ConventionRepository $conventionRepository): Response
    {

        
        $attestation = $attestationRepository->findOneBy(array("etudiant"=>$request->request->get('etudiant'))) ;
        if ($attestation == null){
            $attestation = new Attestation();
        }
        $etudiant = $etudiantRepository->find($request->request->get('etudiant'));
        $convention = $conventionRepository->findOneBy(array("nom"=>$request->request->get('convention')));
        
        // dd($request->request);
        $attestation->setEtudiant($etudiant);
        $attestation->setConvention($convention);
        $attestation->setMessage($request->request->get('message'));
        
       

        
            $attestationRepository->add($attestation, true);

            return $this->redirectToRoute('app_attestation_index', [], Response::HTTP_SEE_OTHER);
        
        
      
        
    }

    /**
     * @Route("/{id}", name="app_attestation_show", methods={"GET"})
     */
    public function show(Attestation $attestation): Response
    {
        
        return $this->render('attestation/show.html.twig', [
            'attestation' => $attestation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_attestation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Attestation $attestation, AttestationRepository $attestationRepository): Response
    {
        $form = $this->createForm(AttestationType::class, $attestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attestationRepository->add($attestation, true);

            return $this->redirectToRoute('app_attestation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attestation/edit.html.twig', [
            'attestation' => $attestation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_attestation_delete", methods={"POST"})
     */
    public function delete(Request $request, Attestation $attestation, AttestationRepository $attestationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attestation->getId(), $request->request->get('_token'))) {
            $attestationRepository->remove($attestation, true);
        }

        return $this->redirectToRoute('app_attestation_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/convention/{id}"), name="app_convention_by_id", methods={"GET"})
     */
    public function getConventionById(ConventionRepository $conventionRepository, $id): Response
    {
        $convention = $conventionRepository->find($id);
        
        $result  = ["id"=>$convention->getId(),
                    "nbHeur"=>$convention->getNbHeur(),
                    "nom"=>$convention->getNom()
        ];
        // $response = new Response(json_encode(array("convention"=>$conventionRepository->find($id))));
        // $response->headers->set('Content-Type', 'application/json');

        // dd($response);

        return $this->json($result);
    }
}
