<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;

class SendOrderConfirmationEmail implements ShouldQueue, ShouldBeEncrypted
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected float $totalCost;
    protected User $user;

    public function __construct(User $user, float $totalCost)
    {
        $this->totalCost = $totalCost;
        $this->user = $user;
    }

    public function handle()
    {
        // you start sending the emails by uncommenting the following line
        //Mail::to($this->user->email)->send(new OrderConfirmation($this->totalCost));
    }
}
