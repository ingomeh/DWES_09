<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class CreateUserController extends AbstractController
{
    #[Route('/createUser/{action}', name: 'create_user')]
    public function index(EntityManagerInterface $entityManager, Request $request, int $action = 0): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Dice a doctrine que quiere guardar un producto (pero todavía no lo guarda)
            $entityManager->persist($user);
            // ejecuta la pregunta
            $entityManager->flush();
            return $this->redirectToRoute('create_user', ['action'=> 1]);
        }

        return $this->render('create_user/index.html.twig',[
            'formulario'=>$form->createView(),
            'action'=> $action
        ]);
    }
}
