<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\LoginType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends AbstractController
{
    #[Route('/login/{action}', name: 'login_user')]
    public function index(UserRepository $userRepository, Request $request, int $action = 0): Response
    {
        $user = new User();
        $form = $this->createForm(LoginType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($userRepository->isValidCredential($user->getEmail(),$user->getPassword())){
                return $this->redirectToRoute('login_user',['action' => 1]);
            }else{
                return $this->redirectToRoute('login_user',['action' => 2]);
            }
        }

        return $this->render('login_user/index.html.twig',[
            'formulario' => $form->createView(),
            'action' => $action
        ]);
    }
}
