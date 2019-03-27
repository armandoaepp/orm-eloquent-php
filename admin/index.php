<?php
 require_once "sesion_admin.php" ;
 loginRedirect();
?>
<!DOCTYPE html>
<html lang="es_ES">

<head>
  <?php

    $setvar = array(
      'titulo'     => 'Administrador | Escuela Cumbre ',
      'follow'      => '',
      'description' => 'Escuela Cumbre Administrador',
      'keywords'    => 'Escuela cumbre',
      'active'      => [1,0]
    );

    $sidebar = array(
      'sidebar_class'     => '',
      'sidebar_toggle'      => 'only',
      'sidebar_active'      => [0,0],
     );

     require_once "layout/head_links.phtml";
?>

</head>

<body>
  <?php require_once "layout/header.phtml" ;?>
  <div class="app-wrap">
    <?php require_once "layout/sidebar.phtml";?>

    <main role="main" class="main">
      <div class="container py-3 py-md-4">
        <div class="row pt-1 pt-md-4">
          <div class="col-12 text-center">
            <h1 class="open-sans"> Bienvenido </h1>
            <h2 class="open-sans"> Administrador :
              <?php echo  $_SESSION['USER']->nombre . ' ' . $_SESSION['USER']->apellidos  ?> </h2>
          </div>
        </div>
    </main>

  </div>

  <?php require_once "layout/foot_links.phtml"?>

</body>

</html>