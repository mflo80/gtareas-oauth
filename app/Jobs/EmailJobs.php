<?php

namespace App\Jobs;

use App\Mail\EmailClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class EmailJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $datos;

    public $tries = 3;

    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    public function handle()
    {
        $email = new EmailClass($this->datos);
        Mail::to($this->datos['to'])->send($email);
    }

    public function retryUntil()
    {
        return now()->addSeconds(10);
    }
}
