<?php

namespace App\Jobs;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fromTitle, $email, $bcc, $title, $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $bcc, $title, $content)
    {
        $this->fromTitle = 'ZendVN';
        $this->email = $email;
        $this->bcc = $bcc;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return false
     */
    public function handle()
    {
        $email = $this->email;
        $title = $this->title;
        $content = $this->content;
        $bcc = $this->bcc;

        $mail = json_decode(Setting::where('key_value', '=', 'setting-email')->first()->value, true);
        if (empty($mail))
            return false;
        else {
            Config::set('mail.username', $mail['email']);
            Config::set('mail.password', $mail['password']);
            Mail::send([], [], function ($message) use ($mail, $email, $bcc, $title, $content) {
                $message->from($mail['email'], $this->fromTitle);
                if (!empty($email)) $message->to($email);
                $message->bcc($bcc);
                $message->subject($title);
                $message->setBody($content, 'text/html');
            });
            return true;
        }
    }
}
