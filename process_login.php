<?php
include 'db_connect.php';
include 'functions.php';
sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura
if(isset($_POST['username'], $_POST['p'])) { 
   $username = $_POST['username'];
   $password = $_POST['p']; // Recupero la password criptata.
   if(login($username, $password, $mysqli) == true) {
      // Login eseguito
      header('Location: ./admin.php');
   } else {
      // Login fallito
      header('Location: ./login.php?error=1');
   }
} else { 
   // Le variabili corrette non sono state inviate a questa pagina dal metodo POST.
   http_response_code(404);
   die();
}
?>