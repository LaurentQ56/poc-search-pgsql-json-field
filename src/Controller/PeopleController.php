<?php

namespace App\Controller;

use App\Entity\People;
use App\Repository\PeopleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PeopleController extends AbstractController
{
    public function __construct(private readonly PeopleRepository $peopleRepository)
    {
    }

    #[Route('/people', name: 'app_people', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PeopleController.php',
        ]);
    }

    #[Route('/people', name: 'add_people', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $contact = [
            'title' => 'Mr',
            'firstname' => 'toto',
            'lastname' => 'toto',
            'phone' => '0638331115',
            'email' => 'toto@toto.fr',
        ];
        $address = [
            'streetNumber' => '1',
            'streetType' => 'rue',
            'streetName' => 'toto',
            'postalCode' => '41500',
            'city' => 'toto',
            'concession' => 'france',
        ];

        $people = (new People())->setAddress($address)->setContact($contact);

        $this->peopleRepository->add($people, true);

        return $this->json([
            'message' => 'People created!'
        ]);
    }
}
