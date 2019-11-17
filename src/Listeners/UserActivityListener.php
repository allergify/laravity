<?php

namespace Laravity\Listeners;

use Aws\Kinesis\KinesisClient;
use App\Events\UserActivityEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserActivityListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserActivityEvent $event)
    {
        try {
            $kinesisClient = new KinesisClient([
                'region' => config('aws.region'),
                'version' => '2013-12-02',
                'credentials' => [
                    'key' => config('aws.access_key_id'),
                    'secret' => config('aws.secret_access_key'),
                ]
            ]);
            $result = $kinesisClient->putRecord([
                'StreamName' => config('aws.user_activiy_stream'),
                'PartitionKey' => config('aws.user_activiy_partition'),
                'Data' => json_encode($event->userActivity->activity)
            ]);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e->getMessage());
            }
        }
    }
}
