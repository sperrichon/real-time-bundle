<?php

namespace SP\RealTimeBundle\Controller;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PresenceController extends Controller
{
    /**
     * @Method("POST")
     * @Route("/realtime/presence/{channel}", name="sp_real_time_presence_subscribe")
     *
     * @param string $channel
     *
     * @return JsonResponse
     */
    public function subscribe(string $channel): JsonResponse
    {
        return new JsonResponse($this->get('sp_real_time.presence')->subscribe($channel));
    }

    /**
     * @Method("DELETE")
     * @Route("/realtime/presence/{channel}/{uuid}", name="sp_real_time_presence_unsubscribe")
     *
     * @param string $channel
     *
     * @return Response
     */
    public function unsubscribe(string $channel, string $uuid): Response
    {
        try {
            $parsedUuid = Uuid::fromString($uuid);
        } catch (InvalidUuidStringException $e) {
            throw new BadRequestHttpException('Invalid uuid', $e);
        }

        if (!$this->get('sp_real_time.presence')->unsubscribe($channel, $parsedUuid)) {
            throw new NotFoundHttpException("UUID '${parsedUuid}' not found in channel '${channel}'");
        }

        return new Response('', 204);
    }

    /**
     * @Method("POST")
     * @Route("/realtime/presence/{channel}/{uuid}/beacon_unsubscribe", name="sp_real_time_presence_beacon_unsubscribe")
     *
     * @param string $channel
     * @param string $uuid
     *
     * @return Response
     */
    public function unsubscribeBeacon(string $channel, string $uuid): Response
    {
        return $this->unsubscribe($channel, $uuid);
    }
}
