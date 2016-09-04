<?php

namespace Fsociety\Console\Commands;

use Fsociety\Mail\ArgLinkUpdatedMail;
use Fsociety\Models\ArgTracking;
use Fsociety\Models\User;
use Fsociety\Services\ArgService;
use Illuminate\Console\Command;
use Mail;

class UpdateArgLinks extends Command
{
    protected $signature = 'fsociety:updateArgLinks';
    protected $description = 'Update modified time if a Arg Link changes';
    protected $argService;

    public function __construct(ArgService $argService)
    {
        parent::__construct();
        $this->argService = $argService;
    }

    public function handle()
    {
        ArgTracking::all()->each(function ($arg) {
            if ($this->argService->updateArgLinkHash($arg)) {
                $this->info("{$arg->name} has been updated");
                User::all()->each(function ($user) use ($arg) {
                    try {
                        Mail::to($user->email)->send(new ArgLinkUpdatedMail($arg));
                    } catch(\Swift_TransportException $ex) {
                        $this->error("Error Sending mail to: {$user->email}");
                        return;
                    }
                    $this->info("Email sent to: {$user->email}");

                });
            }
        });
    }
}
