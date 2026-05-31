<?php
// app/Mail/BusinessRejectedMail.php

namespace App\Mail;

use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BusinessRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $business;
    public $reason;
    public $supportEmail;

    public function __construct(Business $business, $reason)
    {
        $this->business = $business;
        $this->reason = $reason;
        $this->supportEmail = 'support@' . str_replace('www.', '', parse_url(url('/'), PHP_URL_HOST));
    }

    public function build()
    {
        return $this->subject('[' . config('app.name') . '] Thông báo về đăng ký doanh nghiệp')
                    ->view('emails.business-rejected');
    }
}