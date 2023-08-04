<?php

namespace App\Controller;

use App\Repository\FranchiseRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/franchises")
 */
class FranchiseController extends AbstractController
{
    /**
     * @Route("/around/{CP}", name="franchises_around", methods={"GET"})
     */
    public function franchises_around(SerializerInterface $serializer, FranchiseRepository $franchiseRepository, int $CP): Response
    {
        if ($CP >= 9999 && $CP <= 99999) {
            $franchises = $franchiseRepository->findByCP($CP);
            $jsonContent = $serializer->serialize($franchises, 'json');
        } else {
            throw new Exception('CP doit être compris entre 9999 et 99999', 1);
        }

        return new Response($jsonContent);
    }
}
