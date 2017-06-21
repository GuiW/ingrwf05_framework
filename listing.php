<?php
  //avec require, s'il ne trouve pas le fichier, le script s'arrête
  require("config.php")
?>
<?php
// ************************************************************************** //

//On met TOUJOURS les requêtes INSERT avant les SELECT
if ( isset($_POST['insert_personne']) ) : 
  //"sprintf" recoit 7 arguments : la requête + les 6 variables venant du post
  //On utilise "sprintf" pour retourner une chaîne formatée
  //Le 1er %s correspond à la premiere variable, le 2eme %s correspond au deuxième, etc.
  $sql = sprintf("INSERT INTO personnes SET nom = '%s', prenom = '%s', email='%s', telephone = '%s', ddn = '%s', genre = '%s'",
  //La fonction addslashes ajoute des slash s'il y a des ' dans le texte
  addslashes($_POST['nom']),
  addslashes($_POST['prenom']),
  $_POST['email'],
  $_POST['telephone'],
  $_POST['ddn'],
  $_POST['genre']
  );
  $connect -> query($sql);
  echo $connect -> error;

  if ( isset($_GET['ajax']) :
    echo
  endif;

  //la redirection nettoie le post et nous permet de repartir avec une requête propre
  header("location:listing.php");
  exit;
endif; 

// ************************************************************************** //

  //On définit la requête sql dans une variable
  $sql = "SELECT * FROM personnes ORDER BY nom, prenom";

  //On exécute la requête mais on la perd. Il faut donc récupérer le résultat dans une variable ($q_personnes)
  $q_personnes = $connect->query($sql);

  //En cas d'erreur, on l'affiche
  echo $connect->error;

  //On récupère le nombre de lignes
  $nb_personnes = $q_personnes->num_rows;

  // print_r($q_personnes);

// ************************************************************************** //

  //Si on a en paramètre dans l'url "id_personnes", on lance la requête contenue dans $sql.
  if ( isset($_GET['id_personnes']) ) :
    //On veut afficher les lignes dont la propriété id_personnes = la valeur du paramètre id_personnes de l'url
    $sql = "SELECT * FROM personnes WHERE id_personnes =".$_GET['id_personnes'];
    //$the_personne contient la ligne de la table 
    $the_personne = $connect->query($sql);
    echo $connect->error;
    $the_nb_personne = $the_personne->num_rows;
  endif;

  //SI ON A DE L'AJAX
  if ( isset($_GET['ajax']) ) :
    $row = $the_personne -> fetch_object();
    echo json_encode($row);
    exit;
  endif;

// ************************************************************************** //
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Listing</title>

  <link rel="stylesheet" href="css/listing.css">

</head>
<body>
  <main>
   
    <?php if ( isset($the_nb_personne) AND $the_nb_personne > 0 ) :
    
      while ( $row = $the_personne -> fetch_object() ) : ?>
        <h1>Fiche :</h1>
        <h2><?php echo $row->prenom ?> <?php echo $row->nom ?></h2>
        <p class="ddn"><?php echo ($row->genre == "M") ? "Né" : "Née"; ?> le <?php echo ($row->ddn != '') ? $row->ddn : "Inconnu"; ?></p>
        <dl>
          <dt>Email</dt>
          <dd class="email"><?php echo ($row->email != '') ? $row->email : "Inconnu"; ?></dd>
          <dt>Tel</dt>
          <dd class="tel"><?php echo ($row->telephone != '') ? $row->telephone : "Inconnu"; ?></dd>
        </dl>
     <?php endwhile;
    
    else : ?>
      <form action="" method="post">
        <label for="name">Nom :</label>
        <input type="text" name="nom" id="name">
        <br>
        <label for="">Prénom :</label>
        <input type="text" name="prenom" id="firstname">
        <br>
        <label for="">Email :</label>
        <input type="text" name="email" id="mail">
        <br>
        <label for="">Téléphone :</label>
        <input type="text" name="telephone" id="tel">
        <br>
        <label for="">Date de naissance :</label>
        <input type="date" name="ddn" id="ddn">
        <br>
        <fieldset>
          <legend>Genre : </legend>
          <label for="male">M</label>
          <input type="radio" name="genre" value="M" id="male">
          <label for="female">F</label>
          <input type="radio" name="genre" value="F" id="female">
        </fieldset>
        <input type="hidden" name="insert_personne">
        <button>Insérer</button>
        
      </form>

    <?php endif; ?>

  </main>

  <aside>
  <!-- Lien de retour du formulaire -->
  <a href="listing.php" class="return-btn">&larr; Retour</a>
  <!-- On vérifie si il y a des lignes dans notre table -->
  <?php if($nb_personnes > 0) : ?>
  <ul class="listing">
    <!-- Boucle pour afficher les propriétés nom et prénoms de chaque ligne de la table -->
    <?php while( $row = $q_personnes->fetch_object() ) : ?>
      <li><a href="listing.php?id_personnes=<?php echo $row->id_personnes ?>"><?php echo $row->nom ?> <?php echo $row->prenom ?></a></li>
    <?php endwhile; ?>
  </ul>
  <?php else :
    echo "Il n'y a personne.";

  endif; ?>
  </aside>

  <script src="script/ajax.js"></script>
</body>
</html>

<?php
  //print_r($_POST);
?>