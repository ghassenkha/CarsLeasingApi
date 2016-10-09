<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Manager\CarManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * @RouteResource("Car")
 */
class CarController extends Controller
{

    /**
     * Get cars
     *
     * @ApiDoc(
     *     section="Cars services",
     *     description="Get cars",
     *     statusCodes={
     *      "200": "OK"
     *     }
     * )
     */
   public function cgetAction(){
       /** @var CarManager $carManager */
       $carManager = $this->get('car_manager');

       $cars = $carManager->loadCars();

       return array('cars' => $cars);
   }


    /**
     * Get car by id
     *
     * @ApiDoc(
     *     section="Cars services",
     *     description="Get car by id",
     *     requirements={
     *      {"name"="id", "requirement"="\d+", "dataType"="integer", "required"=true, "description"="Car Id"},
     *     },
     *     statusCodes={
     *      "200": "OK",
     *      "404": "Not Found"
     *     }
     * )
     */
    public function getAction($id){
        /** @var CarManager $carManager */
        $carManager = $this->get('car_manager');

        $car = $carManager->loadCar($id);


        if($car === null){
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
        return  array('car' => $car);
    }

    /**
     * Create car
     *
     * @ApiDoc(
     *     section="Cars services",
     *     description="Post car",
     *    input={
     *      "class"="AppBundle\Entity\Car"
     *     },
     *     statusCodes={
     *      "201": "Created",
     *      "400": "Error parameters"
     *     }
     * )
     */
    public function postAction(Request $request){

        $data = $request->request->all();

        /** @var CarManager $carManager */
        $carManager = $this->get('car_manager');

        $car = $carManager->createCar($data);

        return  array('car' => $car);

    }

    /**
     * Delete car
     *
     * @ApiDoc(
     *     section="Cars services",
     *     description="Delete car",
     *     requirements={
     *      {"name"="id", "requirement"="\d+", "dataType"="integer", "required"=true, "description"="Car Id"},
     *     },
     *     statusCodes={
     *      "202": "Deleted",
     *      "400": "Error parameters"
     *     }
     * )
     */
    public function deleteAction($id){

         /** @var CarManager $carManager */
        $carManager = $this->get('car_manager');

        $car = $carManager->loadCar($id);

        if($car === null){
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }


        $car = $carManager->deleteCar($car);

        return null;
    }

     /**
     * Update car
     *
     * @ApiDoc(
     *     section="Cars services",
     *     description="Update car",
     *     requirements={
     *      {"name"="id", "requirement"="\d+", "dataType"="integer", "required"=true, "description"="Car Id"},
     *     },
     *    input={
     *      "class"="AppBundle\Entity\Car"
     *     },
     *     statusCodes={
     *      "204": "Created",
     *      "400": "Error parameters",
     *      "404": "Not found",
     *     }
     * )
     */
    public function putAction($id, Request $request){
        

        /** @var CarManager $carManager */
        $carManager = $this->get('car_manager');
        
        $data = $request->request->all();

        $car = $carManager->loadCar($id);
        if($car === null){
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $car = $carManager->updateCar($car, $data);

        return null;
    }


}
