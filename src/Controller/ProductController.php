<?php

namespace App\Controller;

use App\Repository\ProductDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('/products', name: 'products')]
    public function products(ProductDataRepository $productDataRepository, SerializerInterface $serializer): Response
    {
        $products = $productDataRepository->findAll();

        return $this->json([
            'nodes' => $serializer->normalize($products),
        ]);
    }
}
