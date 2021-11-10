<?php declare(strict_types=1);

namespace App\Tests\Integration\Service;

use App\Repository\CarBrandRepository;
use App\Repository\CarRepository;
use App\Service\CarImport;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CarImportTest extends KernelTestCase
{
    private CarImport $carImport;

    private CarRepository $carRepository;

    private CarBrandRepository $carBrandRepository;

    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        /** @var CarBrandRepository $carBrandRepository */
        $carBrandRepository = self::$container->get(CarBrandRepository::class);
        $this->carBrandRepository = $carBrandRepository;

        /** @var CarRepository $carRepository */
        $carRepository = self::$container->get(CarRepository::class);
        $this->carRepository = $carRepository;

        /** @var CarImport $carImport */
        $carImport = self::$container->get(CarImport::class);
        $this->carImport = $carImport;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $connection = $this->entityManager->getConnection();

        $connection->executeUpdate('DELETE FROM car');
        $connection->executeUpdate('ALTER TABLE car AUTO_INCREMENT=0');
        $connection->executeUpdate('DELETE FROM car_brand');
        $connection->executeUpdate('ALTER TABLE car_brand AUTO_INCREMENT=0');

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function test(): void
    {

    }
}
