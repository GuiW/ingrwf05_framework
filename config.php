<?php

//On définit des constantes qui contiennent les infos de ma DB
define("DB_HOST","localhost");
define("DB_NAME","ingrwf05");
define("DB_USER","root");
define("DB_PASSWORD","root");

//Variable connect qui permet d'identifier la connexion au serveur
$connect = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//le "->" va chercher la propriété error dans l'objet connect
if ($connect->error) :
  echo "erreur de connexion : ".$connect->error;
  exit;

else :
  $connect -> set_charset("utf8");

endif;

?>