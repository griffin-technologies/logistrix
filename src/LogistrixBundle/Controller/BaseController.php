<?php
/**
 * @author: Kieran <k.mckewen@griffin-tech.net>
 */

namespace LogistrixBundle\Controller;


use LogistrixBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class BaseController extends Controller
{
    public function getUser() : User
    {
        return $user = $this->get('security.token_storage')->getToken()->getUser();
    }
}