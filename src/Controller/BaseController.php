<?php

namespace SP\RealTimeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends Controller
{
    /**
     * @Route("/realtime/", name="sp_real_time_endpoint", methods={"GET"})
     *
     * @return Response
     */
    public function subscribe(): Response
    {
        return new Response('', 204);
    }
}
