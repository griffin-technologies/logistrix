<?php
/**
 * @author: Kieran <k.mckewen@griffin-tech.net>
 */

namespace LogistrixBundle\Controller;


use LogistrixBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AuthenticationExpiredException;

abstract class BaseController extends Controller
{
    public function getUser() : User
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        
        return $this->get('security.token_storage')->getToken()->getUser();
    }
}