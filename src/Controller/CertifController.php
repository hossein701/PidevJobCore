<?php

namespace App\Controller;

use App\Entity\Certif;
use App\Form\CertifType;
use App\Repository\CertifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/certif")
 */
class CertifController extends AbstractController
{
    /**
     * @Route("/", name="certif_index", methods={"GET"})
     */
    public function index(CertifRepository $certifRepository): Response
    {
        return $this->render('certif/index.html.twig', [
            'certifs' => $certifRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="certif_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $certif = new Certif();
        $form = $this->createForm(CertifType::class, $certif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($certif);
            $entityManager->flush();

            return $this->redirectToRoute('certif_index');
        }

        return $this->render('certif/new.html.twig', [
            'certif' => $certif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="certif_show", methods={"GET"})
     */
    public function show(Certif $certif): Response
    {
        return $this->render('certif/show.html.twig', [
            'certif' => $certif,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="certif_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Certif $certif): Response
    {
        $form = $this->createForm(CertifType::class, $certif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('certif_index');
        }

        return $this->render('certif/edit.html.twig', [
            'certif' => $certif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="certif_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Certif $certif): Response
    {
        if ($this->isCsrfTokenValid('delete'.$certif->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($certif);
            $entityManager->flush();
        }

        return $this->redirectToRoute('certif_index');
    }
}
