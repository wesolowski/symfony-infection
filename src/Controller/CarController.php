<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\CarBrand;
use App\Repository\CarBrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    private CarBrandRepository $carBrandRepository;

    /**
     * @param \App\Repository\CarBrandRepository $carBrandRepository
     */
    public function __construct(
        CarBrandRepository $carBrandRepository
    )
    {
        $this->carBrandRepository = $carBrandRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $brandList = $this->carBrandRepository->findAll();

        return $this->render('home.html.twig', [
            'brandList' => $brandList,
        ]);
    }

    /**
     * @Route("/brand/{brandId}", name="brand")
     */
    public function brand(int $brandId): Response
    {
        $brand = $this->carBrandRepository->find($brandId);

        if (!$brand instanceof CarBrand) {
            throw $this->createNotFoundException('The brand does not exist');
        }

        return $this->render('brand.html.twig', [
            'brand' => $brand,
        ]);
    }
}
