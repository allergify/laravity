<?php

namespace Laravity;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserActivity
{
    public $activity;

    public function __construct(
        User $user,
        Request $request,
        Response $response
    ) {
        $this->activity = [];

        $this->activity['user_id'] = intval($user->id);
        $this->activity['request_token'] = $request->bearerToken();
        $this->activity['ip'] = $request->ip();
        $this->activity['user_agent'] = $request->userAgent();
        $this->activity['method'] = $request->getMethod();
        $this->activity['route'] = $request->route()->getName();
        $this->activity['parameters'] = $request->route()->parameters();
        $this->activity['url'] = $request->fullUrl();
        $this->activity['response_http_code'] = intval($response->getStatusCode());
        $this->activity['response_time'] = $this->getResponseDispatchTimeHumanized();
        $this->activity['response'] = $response->getContent();
        $this->activity['timestamp'] = date('Y-m-d H:i:s', strtotime('now'));
        $this->activity['payload'] = $this->getRequestPayload($request);
    }

    /**
     * @return string
     */
    protected function getResponseDispatchTimeHumanized()
    {
        $timeTaken = microtime(true) - LARAVEL_START;
        return number_format($timeTaken, 2) . ' seconds';
    }

    /**
     * @return array
     */
    protected function getRequestPayload(Request $request): array
    {
        return $request->all();
    }
}
