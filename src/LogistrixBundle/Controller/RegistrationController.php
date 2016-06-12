<?php
/**
 * @author: Kieran <k.mckewen@griffin-tech.net>
 */

namespace LogistrixBundle\Controller;


use LogistrixBundle\Entity\User;
use LogistrixBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends BaseController
{
    public function registerAction(Request $request) : Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles([User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN, User::ROLE_DEFAULT]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('logistrix_index');
        }

        return $this->render(
            ':default:register.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}