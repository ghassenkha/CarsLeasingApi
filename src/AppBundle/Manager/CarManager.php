<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Car;
use Doctrine\ORM\EntityManager;


class CarManager
{

    private $em;
    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('AppBundle:Car');
    }

    public function loadCars(){
        return $this->repository->findAll();
    }

    public function loadCar($id){
        return $this->repository->find($id);
    }

    public function createCar($data){
        $car = new Car();
        $car
            ->setName($data['name'])
            ->setMarque($data['marque'])
            ->setModel($data['model'])
            ->setDescription($data['description']);


        $this->em->persist($car);
        $this->em->flush();

        return $car;

    }

    public function deleteCar($data){
        
        $this->em->remove($data);
        $this->em->flush();

    }

    public function updateCar($car, $data){
        
        $car
            ->setName($data['name'])
            ->setMarque($data['marque'])
            ->setModel($data['model'])
            ->setDescription($data['description']);


        $this->em->persist($car);
        $this->em->flush();
    }

}