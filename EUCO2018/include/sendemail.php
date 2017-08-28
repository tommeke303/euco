<?php

require_once('phpmailer/class.phpmailer.php');

$mail = new PHPMailer();

if( isset( $_POST['template-contactform-submit'] ) AND $_POST['template-contactform-submit'] == 'submit' ) {
    if( $_POST['template-contactform-name'] != '' AND $_POST['template-contactform-email'] != '' AND $_POST['template-contactform-message'] != '' ) {

        $name = $_POST['template-contactform-name'];
        $email = $_POST['template-contactform-email'];
        $phone = $_POST['template-contactform-phone'];
        $service = $_POST['template-contactform-service'];
        $subject = $_POST['template-contactform-subject'];
        $message = $_POST['template-contactform-message'];

        $subject = isset($subject) ? $subject : 'Nieuw bericht van het contact formulier';

        $botcheck = $_POST['template-contactform-botcheck'];

        $toemail = 'Info@euco2018.be'; // Your Email Address
        $toname = 'EUCO 2018'; // Your Name

        if( $botcheck == '' ) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );
            $mail->Subject = $subject;

            $name = isset($name) ? "Naam: $name<br><br>" : '';
            $email = isset($email) ? "Email: $email<br><br>" : '';
            $phone = isset($phone) ? "Telefoonnummer: $phone<br><br>" : '';
            $message = isset($message) ? "Bericht: $message<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>Dit bericht was verzonden van:: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$name $email $phone $service $message $referrer";

            $mail->MsgHTML( $body );
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                echo 'We have <strong>successfully</strong> received your Message and will try to get back at you within 72 hours';
            else:
                echo 'Email <strong>could not</strong> be sent due to some Unexpected Error. Please Try Again later.<br /><br /><strong>Reason:</strong><br />' . $mail->ErrorInfo . '';
            endif;
        } else {
            echo 'Bot <strong>Detected</strong>.! Clean yourself Botster.!';
        }
    } else {
        echo 'Please <strong>Fill up</strong> all the Fields and Try Again.';
    }
} else {
    echo 'An <strong>unexpected error</strong> occured. Please Try Again later.';
}

?>