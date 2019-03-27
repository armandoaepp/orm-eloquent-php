<?php
 require_once "sesion_admin.php" ;
 loginRedirect();
?>
<!DOCTYPE html>
<html lang="es_ES">

<head>
  <?php

    $setvar = array(
      'titulo'     => 'Demo | Admin Escuela Cumbre ',
      'follow'      => '',
      'description' => 'demo',
      'keywords'    => 'Escuela cumbre',
      'active'      => [1,0]
    );

    $sidebar = array(
      'sidebar_class'     => 'sidebar-blue',
      'sidebar_toggle'      => 'only',
      'sidebar_active'      => [3,1],
     );

     require_once "layout/head_links.phtml";
?>

</head>

<body>
  <?php require_once "layout/header.phtml" ;?>
  <div class="app-wrap">
    <?php require_once "layout/sidebar.phtml";?>

    <main class="main">

    </main>

  </div>

  <?php require_once "layout/foot_links.phtml"?>

</body>

</html>