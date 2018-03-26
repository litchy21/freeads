<?php
/**
 * Created by PhpStorm.
 * User: Mac
 * Date: 26/03/2018
 * Time: 11:32
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class IndexController
 * @package AppBundle\Controller
 */
class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function showIndexAction(Request $request)
    {
        return $this->render('index/index.html.twig');
    }
}