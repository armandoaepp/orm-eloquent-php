<?php
  session_start();

  function loginRedirect($url = 'login.php')
  {

    if (empty($_SESSION['LOGIN'])){
      // header("Location: ../login", true, 301);
      header("Location: $url ", true, 301);
      exit();
    }

  }

