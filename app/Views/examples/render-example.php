 <?php

 require_once '../../autoload.php';

  // $template_mail = RenderTemplate::getTemplate(APP.'views'.DS.'mails'.DS.'mail-contact') ;

  $template_mail = RenderTemplate::getTemplate(APP.'views/mails/mail-contact') ;


  $data = array(
    'nombre'  => "Armando E.",
    'email'   => "armandoaepp@gmail.com",
    'mensaje' => "Mensaje de Prueba",
  );

  $BODY_MSJ = RenderTemplate::render( $template_mail, $data) ;

  echo "<pre>" ;
  print_r($BODY_MSJ);
  echo "</pre>" ;