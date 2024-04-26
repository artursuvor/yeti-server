<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\DriverManager;

class YetiController extends AbstractController
{ 
    private $conn;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => 'yeti',
            'user' => 'my_user',
            'password' => 'password',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ];

        $this->conn = DriverManager::getConnection($connectionParams);
    }

    // #[Route('/yeti', name: 'yeti')]
    // public function index(): Response
    // {
    // }


    #[Route('/yeti/list', name: 'yeti_list')]
    public function listAction(): Response
    {
        $sql = "SELECT * FROM yeti";
        $stmt = $this->conn->executeQuery($sql);
        $results = $stmt->fetchAllAssociative();

        print_r($results);
        exit();

        return new Response(
            '<html><body>List</body></html>'
        );
    }
}
