<?php 

include_once(dirname(__FILE__) . "/controller.php");
include_once(dirname(__FILE__) . "/../models/pet.php");

class PetController extends Controller {
    private $petRepository;

    function __construct($petRepository) {
        $this->petRepository = $petRepository;
    }

    function getAll() {
        $petsFromDb = $this->petRepository->getAll();
        $pets = array();
        foreach ($petsFromDb as $petFromDb) {
            $pet = $this->_mapPetFromDbToModel($petFromDb);
            array_push($pets, $pet);
        }
        return $pets;
    }

    function getOne($petId) {
        $petFromDb = $this->petRepository->getOne($petId);
        if (!$petFromDb) return null;
        $pet = $this->_mapPetFromDbToModel($petFromDb);
        return $pet;
    }

    function update($petToUpdate) {
        $error = parent::_validateRequestFields(['id', 'name', 'breed', 'ownerPhone'], $petToUpdate);
        if ($error) return $error;
        $id = $petToUpdate['id'];
        $name = $petToUpdate['name'];
        $breed = $petToUpdate['breed'];
        $ownerPhone = $petToUpdate['ownerPhone'];
        $pet = new Pet($name, $breed, $ownerPhone);
        $pet->setId($id);
        return $this->petRepository->update($pet);
    }

    function delete($petId) {
        return $this->petRepository->delete($petId);
    }

    function create($data) {
        $error = parent::_validateRequestFields(['name', 'breed', 'ownerPhone'], $data);
        if ($error) return $error;
        $name = $data['name'];
        $breed = $data['breed'];
        $ownerPhone = $data['ownerPhone'];
        $pet = new Pet($name, $breed, $ownerPhone);
        print_r("calling petRepository...");
        return $this->petRepository->create($pet);
    }

    function getAllByEmployeeNameOrEmail($employeeNameOrEmail) {
        $petsFromDb = $this->petRepository->getAllByEmployeeNameOrEmail($employeeNameOrEmail);
        $pets = array();
        foreach ($petsFromDb as $petFromDb) {
            $pet = $this->_mapPetFromDbToModel($petFromDb);
            array_push($pets, $pet);
        }
        return $pets;
    }

    function getAllBreeds() {
        $petsFromDb = $this->petRepository->getAllBreeds();
        $breeds = array();
        foreach ($petsFromDb as $petFromDb) {
            array_push($breeds, $petFromDb['RACA']);
        }
        return $breeds;
    }

    function getAllByBreed($breed) {
        $petsFromDb = $this->petRepository->getAllByBreed($breed);
        $pets = array();
        foreach ($petsFromDb as $petFromDb) {
            $pet = $this->_mapPetFromDbToModel($petFromDb);
            array_push($pets, $pet);
        }
        return $pets;
    }

    private function _mapPetFromDbToModel($petFromDb) {
        $pet = new Pet($petFromDb['NOME'], $petFromDb['RACA'], $petFromDb['TELDONO']);
        $pet->setId($petFromDb['ID']);
        $pet->setCreatedAt($petFromDb['DATACADASTRO']);
        return $pet;
    }
}
