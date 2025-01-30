<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;


use App\Repository\StaffRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Entity\Staff;

// controlador de usuario ruta base
#[Route('/tasks', name: 'tasks')]
final class TasksController extends AbstractController
{

    #[Route('/crear', name: 'tasks_crear', methods: ['POST'])]
    public function userRegistrar(EntityManagerInterface $entityManagerInterface, Request $request, StaffRepository $staffRepository): Response
    {

        // obtiene el contenido de la peticion
        $body = $request->getContent();
        $data = json_decode($body, true);

        // Verifica que $data no sea null
        if ($data === null) {
            return $this->json("Datos inválidos", Response::HTTP_BAD_REQUEST);
        }

        $tasks = new Staff();
        $tasks->setName($data['name']);
        $tasks->setDescription($data['description']);
        $tasks->setExpirationDate($data['expiration_date']);
        $tasks->setState($data['state']);
        $tasks->setPriority($data['priority']);
        $tasks->setResponsible($data['responsible']);

        // controlar las entidades , en este caos lo manda al base de datos
        $entityManagerInterface->persist($tasks);
        $entityManagerInterface->flush();

        return $this->json("Tarea creada", Response::HTTP_CREATED);
    }

    // funcin de vista
    #[Route('/view', name: 'tasks_view')]
    public function userGet(StaffRepository $staffRepository): Response
    {
        // obtiene todos los datos
        $staffs = $staffRepository->findAll();
        $staffJson = array();

        foreach ($staffs as $staff) {
            $staffJson[] = [
                'id' => $staff->getId(),
                'nombre' => $staff->getName(),
                'descripcion' => $staff->getDescription(),
                'fecha expiracion' => $staff->getExpirationDate(),
                'estado' => $staff->getState(),
                'prioridad' => $staff->getPriority(),
                'responsable' => $staff->getResponsible(),
            ];
        }

        return $this->json($staffJson);
    }

    // funcion de borrar
    #[Route('/delete/{id}', name: 'tasks_delete', methods: ['DELETE'])]
    public function userBorrar($id, StaffRepository $staffRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $staff = $staffRepository->find($id);

        //  valida en caso que no exista
        if (!$staff) {
            return $this->json("Tarea no encontrado", Response::HTTP_NOT_FOUND);
        }

        $entityManagerInterface->remove($staff);
        $entityManagerInterface->flush();

        return $this->json("Tarea borrado", Response::HTTP_OK);
    }

    #[Route('/update/{id}', name: 'tasks_update', methods: ['PUT'])]
    public function userActualizar($id, Request $request, StaffRepository $staffRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $staff = $staffRepository->find($id);

        // valida en caso que no exista
        if (!$staff) {
            return $this->json("Tarea no encontrado", Response::HTTP_NOT_FOUND);
        }

        // obtener datos del request
        $data = json_decode($request->getContent(), true);

        // actualizar campos
        if (isset($data['name'])) {
            $staff->setName($data['name']);
        }
        if (isset($data['description'])) {
            $staff->setDescription($data['description']);
        }
        if (isset($data['expiration_date'])) {
            $staff->setExpirationDate($data['expiration_date']);
        }
        if (isset($data['state'])) {
            $staff->setState($data['state']);
        }
        if (isset($data['priority'])) {
            $staff->setPriority($data['priority']);
        }
        if (isset($data['responsible'])) {
            $staff->setResponsible($data['responsible']);
        }

        // guardar cambios
        $entityManagerInterface->persist($staff);
        $entityManagerInterface->flush();

        // respuesta
        return $this->json("Tarea actualizado", Response::HTTP_OK);
    }
}
