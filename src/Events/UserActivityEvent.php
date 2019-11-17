<?php

namespace Laravity\Events;

use Laravity\UserActivity;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserActivityEvent
{
    use Dispatchable, SerializesModels;

    /** @var UserActivity */
    public $userActivity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserActivity $userActivity)
    {
        $this->userActivity = $userActivity;
    }
}
