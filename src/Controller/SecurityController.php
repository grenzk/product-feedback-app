<?php

namespace App\Controller;

use ApiPlatform\Metadata\IriConverterInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(IriConverterInterface $iriConverter, #[CurrentUser] User $user = null): Response
    {
        if (!$user) {
            return $this->json([
                'error' => 'Invalid login request: Set Content-Type to "application/json"'
            ], 401);
        }

        return new Response(null, 204, [
            "Location" => $iriConverter->getIriFromResource($user)
        ]);
    }
}
