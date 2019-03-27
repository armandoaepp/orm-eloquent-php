<?php
 session_start();
 if (!empty($_SESSION['LOGIN']))
 {
   header("Location: ../admin/index.php", true, 301);
   exit();
 }
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <?php
$path = '';

$setvar = array(
    'titulo' => 'Login  | Escuela Cumbre ',
    'follow' => '',
    'description' => 'Login Admin Instituto Cumbre',
    'keywords' => 'login, login admin, tables css, tables bootstrap 4, admin template',
    'active' => [1, 0],
);

$sidebar = array(
    'sidebar_class' => 'sidebar-blue',
    'sidebar_toggle' => 'only',
    'sidebar_active' => [4, 1],
);

require_once "layout/head_links.phtml";
?>
</head>

<body>


  <main role="main" class="main min-vh-100 d-flex align-items-center bg-primary">

    <div class="container py-3 py-md-4">
      <div class="row">

        <div class="col-12 col-md-6 col-lg-4 mx-auto">

          <div class="text-center">
            <div class="w-75 mx-auto mb-4">
              <img class="img-fluid" src="img/instituto-superior-de-gastronomia-cumbre-logo-white.svg" alt="">
            </div>
            <h1 class="f-open-sans h5 mb-3 text-gray-500 "> Ingreso al Sistema </h1>
          </div>

          <form id="formLogin" class="form-login mb-3">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="text" class="form-control" name="email" id="email" required="" placeholder="Email">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <input type="password" class="form-control" name="password" id="password" required=""
                    placeholder="Password">
                </div>
              </div>

            </div>

            <button type="submit" class="f-open-sans btn btn-danger btn-block" role="button"> Login </button>

            <div id="alertConfirmPrincipal" class="alert alert-success fade" role="alert">
              <div id="alertMensaje">
              </div>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>

  </main>


  <?php require_once "layout/foot_links.phtml"?>



</body>

</html>