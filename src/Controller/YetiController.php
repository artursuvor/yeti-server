<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\YetiRepository;
use Yeti;
use YetiCrudException;

class YetiController extends AbstractController
{ 
    public function __construct(
        private YetiRepository $yetiRepository,
    ){
    }

    #[Route('/yeti/list', name: 'yeti_list')]
    public function listAction(): Response
    {
        $results = $this->yetiRepository->findAll();
    
        $response = new Response(json_encode($results));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
    
        return $response;
    }

    #[Route('/yeti/get/{id}', name: 'get_yeti_by_id')]
    public function getByIdAction(int $id): Response
    {
        $yeti = $this->yetiRepository->getById($id);

        if ($yeti === null) {
            throw $this->createNotFoundException('The Yeti with id ' . $id . ' does not exist.');
        }

        $response = new Response(json_encode($yeti->toArray()));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');

        return $response;
    }

    #[Route('/yeti/delete/{id}', name: 'delete_yeti', methods: ['POST'])]
    public function deleteAction(int $id): Response
    {
        $yeti = $this->yetiRepository->getById($id);

        if ($yeti === null) {
            throw $this->createNotFoundException('The Yeti with id ' . $id . ' does not exist.');
        }

        try {
            $this->yetiRepository->deleteById($id);
        } catch (YetiCrudException $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response('Yeti deleted!', Response::HTTP_OK);
    }

    #[Route('/yeti/add', name: 'add_yeti', methods: ['POST'])]
    public function addAction(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
    
        $yeti = new Yeti(
            name: $data['name'],
            height: $data['height'],
            weight: $data['weight'],
            location: $data['location'],
            photoUrl: $data['photo_url'],
            gender: $data['gender'],
        );

        try {
            $this->yetiRepository->createYeti($yeti);
        } catch (YetiCrudException $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    
        return new Response('Yeti created!', Response::HTTP_CREATED);
    }
    
}
