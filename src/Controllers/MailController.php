<?php

namespace Controllers;
use Lib\Pages;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class MailController {

    private Pages $pagina;
   
    public function __construct()
    {
        // Crea una nueva instancia de Pages
        $this->pagina = new Pages();
       

    }

    public function mailregistro($nombre, $email):void{
        
        $mail = new PHPMailer();
        // configure an SMTP
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '41d8c9900b45a9';
        $mail->Password = '824ee0f2e06aaf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        $mail->setFrom('no-reply@registered-domain', 'Tu Web');
        $mail->addAddress($email, $nombre);
        $mail->Subject = 'Gracias por registrate en nuestra web';
        // Set HTML 
        $mail->isHTML(TRUE);
        $mail->Body = '<html>Gracias por registrarte en nuestra web</html>';
        
        // send the message
        if(!$mail->send()){
            echo 'El mensaje no se pudo enviar.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'El mensaje se ha enviado';
        }
    }
    
    public function mailcompra($pedido_id, $email, $direccion, $provincia, $localidad, $coste_total, $productos): void
{
    $mail = new PHPMailer();

    // Configurar SMTP
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = '41d8c9900b45a9';
    $mail->Password = '824ee0f2e06aaf';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 2525;

    $mail->setFrom('no-reply@registered-domain', 'Tu Web');
    $mail->addAddress($email);
    $mail->Subject = 'Gracias por su compra - Pedido #' . $pedido_id;

    // Crear la lista de productos en HTML
    $productos_html = '<ul>';
    foreach ($productos as $producto) {
        $productos_html .= '<li>' . $producto['nombre'] . ' x ' . $producto['cantidad'] . ' - $' . $producto['precio'] * $producto['cantidad'] . '</li>';
    }
    $productos_html .= '</ul>';

    // Configurar HTML
    $mail->isHTML(true);
    $mail->Body = '
        <html>
            <body>
                <p>Gracias por comprar en nuestra web. Su pedido es #' . $pedido_id . '</p>
                <p>Dirección de envío: ' . $direccion . ', ' . $localidad . ', ' . $provincia . '</p>
                <p>Coste total: $' . $coste_total . '</p>
                <p>Productos:</p>
                ' . $productos_html . '
            </body>
        </html>';

    // Enviar el correo
    if (!$mail->send()) {
        echo 'El mensaje no pudo ser enviado. Error de Mailer: ' . $mail->ErrorInfo;
    } else {
        echo 'Mensaje enviado correctamente';
    }
}
    

    
}


