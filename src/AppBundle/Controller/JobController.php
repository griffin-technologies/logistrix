<?php
/**
 * Created by PhpStorm.
 * User: Kieran
 * Date: 12/06/2016
 * Time: 15:58
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JobController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function defaultAction()
    {
        return $this->render(
            ':default:index.html.twig'
        );
    }
}