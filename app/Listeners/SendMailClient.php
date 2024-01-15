<?php

namespace App\Listeners;

use App\Events\ApprovedClient;
use App\Mail\ApprovedClientEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailClient
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ApprovedClient $event): void
    {
       $clientId = $event->clientId;
       $client = User::findOrFail($clientId);
       Mail::to($client->email)->send(new ApprovedClientEmail($client));

    }
}
