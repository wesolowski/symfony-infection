<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Car as CarEntity;
use App\Entity\CarBrand;
use App\Repository\CarBrandRepository;
use App\Repository\CarRepository;
use App\Service\Mapping\Car;
use App\Service\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;

class CarImport
{
    /**
     * @var \App\Service\Mapping\Car
     */
    private Car $carMapping;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var \App\Repository\CarRepository
     */
    private CarRepository $carRepository;

    /**
     * @var \App\Repository\CarBrandRepository
     */
    private CarBrandRepository $carBrandRepository;
    /**
     * @var \App\Service\Validator\Validator
     */
    private Validator $validator;

    public function __construct(
        Car $carMapping,
        EntityManagerInterface $entityManager,
        CarRepository $carRepository,
        CarBrandRepository $carBrandRepository,
        Validator $validator
    )
    {
        $this->carMapping = $carMapping;
        $this->entityManager = $entityManager;
        $this->carRepository = $carRepository;
        $this->carBrandRepository = $carBrandRepository;
        $this->validator = $validator;
    }

    public function import(string $pathToJson)
    {
        $carDtoList = $this->convertJsonToCarDtoList($pathToJson);

        foreach ($carDtoList as $carDto) {
            $carBrandEntity = $this->carBrandRepository->findOneBy(['name' => $carDto->getBrand()]);
            if(!$carBrandEntity instanceof CarBrand) {
                $carBrandEntity = new CarBrand();
                $carBrandEntity->setName($carDto->getBrand());
                $this->entityManager->persist($carBrandEntity);
                $this->entityManager->flush();
            }

            $carEntity = $this->carRepository->findOneBy(['model' => $carDto->getModel(), 'brand' => $carBrandEntity]);
            if(!$carEntity instanceof CarEntity) {
                $carEntity = new CarEntity();
                $carEntity->setModel($carDto->getModel());
                $carEntity->setBrand($carBrandEntity);
            }

            $carEntity->setDescription($carDto->getDescription());

            $this->entityManager->persist($carEntity);
        }

        $this->entityManager->flush();
    }

    /**
     * @param string $pathToJson
     *
     * @return \App\Service\Dto\CarImportDto[]
     */
    private function convertJsonToCarDtoList(string $pathToJson): array
    {
        $carDtoList = [];
        $carInfoList = json_decode(file_get_contents($pathToJson), true, 512, JSON_THROW_ON_ERROR);

        foreach ($carInfoList as $carInfo) {
            if($this->validator->isValid($carInfo)) {
                $carDtoList[] = $this->carMapping->mapJsonToCarImportDto($carInfo);
            }
        }
        
        return $carDtoList;
    }
}
