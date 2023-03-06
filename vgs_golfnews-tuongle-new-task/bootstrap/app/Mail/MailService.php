<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class MailService
{
    private $fromTitle;

    public function __construct()
    {
        $this->fromTitle = 'Gilimex';
    }

    public function sendEmail($email, $title, $content, $bcc = [], $attach = '', $option = [])
    {
        $mail = json_decode(Setting::where('key_value', '=', 'setting-email')->first()->value, true);
        if (empty($mail))
            return false;
        else {
            Config::set('mail.username', $mail['email']);
            Config::set('mail.password', $mail['password']);
            Mail::send([], [], function ($message) use ($mail, $email, $bcc, $title, $content) {
                $message->from($mail['email'], $this->fromTitle);
                $message->to($email);
                $message->bcc($bcc);
                $message->subject($title);
                $message->setBody($content, 'text/html');
            });
            return true;
        }
    }

    public function setDataTemplate($template, $data)
    {
        foreach ($data as $key => $value)
            $template = $this->setValueTemplate($key, $value, $template);

        return $template;
    }

    public function setValueTemplate($key, $value, $template)
    {
        return str_replace("{{ $key }}", $value, $template);
    }
}