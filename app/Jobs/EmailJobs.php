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

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        $email = new EmailClass($this->datos);
        Mail::to($this->datos['to'])->send($email);
    }
}
