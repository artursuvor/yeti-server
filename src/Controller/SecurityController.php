<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;


class SecurityController extends AbstractController
{
  public function __construct(
    private JWTTokenManagerInterface $jwtManager,
    private UserRepository $userRepository,
  ) {
  }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request): Response
    {
         $credentials = $request->toArray();

         if (!$this->isValidCredentials($credentials)) {
             throw new \UserException('Invalid credentials');
         }        
 
         $response = new Response();
         $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
         
         return $response;
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \Exception('This method should not be called directly.');
    }


    private function isValidCredentials(array $credentials): bool
    {
        $username = $credentials['username'];
        $password = $credentials['password'];

        $user = $this->userRepository->getUserByLogin($username);

        if ($user === null || !$user->verifyPassword($password)) {
            throw new \UserException('Invalid credentials ' . $user->getUsername());
        }

        return true;
    }
}
