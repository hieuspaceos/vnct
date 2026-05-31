<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Requests\sendmail;
use App\Models\Contact;
class MailerController extends Controller
{
    public function SendEmail(Request $request) {
    	//dd(df8);
        
    	Contact::Create([
    		"Name" => $request->name,
    		"Phone" => $request->thudo,
    		"Email" => $request->email,
    		"Address" => $request->subject,
    		"Content" => $request->content,
    	]);
    	//dd($request->input());
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            // if(df3=="" && df4=="")
            // {
            	$mail->Username = 'vckhang.it@gmail.com';   //  sender username
            	$mail->Password = 'yhoatohxzusgmene';       // sender password
        	//}
        	// else
        	// {
        	// 	$mail->Username = df3;   //  sender username
            // 	$mail->Password = df4;
        	// }
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465
            $mail->CharSet = "UTF-8"; 
            $mail->setFrom("info@vnct.org", 'VNCT Contacto');
            $mail->addAddress("info@vnct.org");
            //$mail->addCC($request->emailCc);
            //$mail->addBCC($request->emailBcc);

            $mail->addReplyTo($request->email, $request->name);

            /*if(isset($_FILES['emailAttachments'])) {
                for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }*/


            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $request->subject;
            $body = '';
            $body.= '<div>Nom et Prénom*: '.$request->name.'</div>';
            $body.= '<div>Email: '.$request->email.'</div>';
            
            $body.= '<div>Sujet*: '.$request->subject.'</div>';
            $body.= '<div>Message*: '.$request->content.'</div>'; 
            $body.= '<div>La capitale de la France: '.$request->thudo.'</div>';           
            $mail->Body    = $body;

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {
                return back()->with("failed", "Correo electrónico no enviado.")->withErrors($mail->ErrorInfo);
            }
            
            else {
                return back()->with("success", "El correo electrónico ha sido enviado.");
            }

        } catch (Exception $e) {
             return back()->with('error','Correo electrónico no enviado.');
        }
    }
    public function SendEmailall($array) {
       
        
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            if(df3=="" && df4=="")
            {
                $mail->Username = 'vckhang.it@gmail.com';   //  sender username
                $mail->Password = 'yhoatohxzusgmene';  
            }
            else
            {
                $mail->Username = df3; 
                $mail->Password = df4;
            }
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->CharSet = "UTF-8"; 
            $mail->setFrom(df8, 'SENSE NEST');
            $mail->addAddress(df8); 
            if($array["email"]!="")
            { 
                $mail->addAddress($array["email"]);        
            }
            $mail->addReplyTo($array["email"]);
            $mail->isHTML(true);
            $mail->Subject = $array["subject"];
            $body = '';                
            $mail->Body    = $array["body"];
            if( !$mail->send() ) {
                return false;//back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
            }            
            else {
                return true; //back()->with("success", "Email has been sent.");
            }
        } catch (Exception $e) {
             return false;//back()->with('error','Message could not be sent.');
        }
    }
}
