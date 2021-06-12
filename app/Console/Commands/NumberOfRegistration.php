<?php

namespace App\Console\Commands;

use App\Http\Controllers\Client\ClientController;
use App\Models\Client;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NumberOfRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:numberOfRegistration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'a Cron job to daily send an email with the total number of new registrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $clientCount= $client->count(1);
        $user = new User();
        $userEmails = $user->select('email')->get()->pluck('email')->toArray();
            Mail::raw("this is an automatically generated mail ". $clientCount, function ($message) use ($clientCount,$userEmails){
                $message->from("basma-challenge@mail.com");
                $message->to($userEmails)->subject('daily update');
            });
        $this->info($clientCount);

    }
}
