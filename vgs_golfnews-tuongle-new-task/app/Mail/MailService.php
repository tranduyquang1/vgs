<?php

namespace App\Mail;

use App\Jobs\SendEmailJob;
use Carbon\Carbon;

class MailService
{
    public function sendEmail($email, $title, $content, $bcc = [], $attach = '', $option = [])
    {
        $jobSendMail = (new SendEmailJob($email, $bcc, $title, $content))->delay(Carbon::now()->addSeconds(5));
        dispatch($jobSendMail);
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
