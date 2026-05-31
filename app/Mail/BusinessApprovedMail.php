<?php
// app/Mail/BusinessApprovedMail.php

namespace App\Mail;

use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BusinessApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $business;
    public $loginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Business $business)
    {
        $this->business = $business;
        $this->loginUrl = route('business.login.form');
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('[' . config('app.name') . '] Tài khoản doanh nghiệp đã được duyệt')
                    ->view('emails.business-approved')
                    ->with([
                        'business' => $this->business,
                        'loginUrl' => $this->loginUrl,
                        'appName' => config('app.name'),
                        'year' => now()->year
                    ]);
    }
}