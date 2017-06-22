<?php require("config.php");?>
<?php 

    if (isset($_POST['insert_personne'])) :
        $sql = sprintf("INSERT INTO personnes SET nom = '%s', prenom = '%s', email = '%s', ddn = '%s', genre = '%s', telephone = '%s'",
        addslashes($_POST['nom']),
        addslashes($_POST['prenom']),
        $_POST['email'],
        $_POST['ddn'],
        $_POST['genre'],
        $_POST['telephone']
        );
        $connect->query($sql);
        echo $connect->error;

        //Si on utilise ajax
        if ( isset($_GET['ajax']) AND $connect->errno == 0 ) :
          echo $connect->insert_id;
          exit;
        else :
          echo "pas ok";
          exit;
        endif;

        header("location:listing.php");
        exit;
    endif;

    $sql = "SELECT * FROM personnes ORDER BY nom, prenom";
    $q_personnes = $connect->query($sql);
    echo $connect->error;
    $nb_personnes = $q_personnes->num_rows;
    //print_r($q_personnes);

    if ( isset($_GET['id_personnes']) ) :
        $sql = "SELECT * FROM personnes WHERE id_personnes = ".$_GET['id_personnes'];
        $the_personne = $connect->query($sql);
        echo $connect->error;
        $the_nb_personne = $the_personne->num_rows;

        if ( isset($_GET['ajax'])) :
          echo json_encode($the_personne ->fetch_object());
        exit;
        endif;
    endif;

    if ( isset($_GET['ajax'])) :
        while($row = $q_personnes ->fetch_object()) :
          $listing[]=$row;
        endwhile;
        echo json_encode($listing);
        exit;
    endif;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listing</title>
    <style>
        body {
            display:flex;
            width: 75%;
            margin: auto;
        }
        main {
            width: 80%;
        }
        label, .label {
            display: inline-block;
            width: 170px;
            text-align: right;
        }
        input+label {
            display: inline;
        }
        a.current {
            color: red;
        }
    </style>
</head>
<body>
    <main>
    <?php if ( isset($the_nb_personne) AND $the_nb_personne > 0) :
        while ( $row = $the_personne -> fetch_object() ) :?>
        <h1>Fiche</h1>
        <h2><?php echo $row->prenom;?> <?php echo $row->nom;?></h2>
        <p><?php echo ($row->genre == "F") ? "Née" : "Né";?> le <?php echo ($row->ddn !='') ? $row->ddn : 'Inconnu';?></p>
        <dl>
            <?php if($row->email != '') :?>
            <dt>Email</dt>
            <dd><?php echo $row->email;?></dd>
            <?php endif;?>
            <dt>Tél.</dt>
            <dd><?php echo $row->telephone;?>1</dd>
        </dl>
        <?php endwhile;
        else : ?>
        <form method="post" action="listing.php" id="insert">
            <label for="nom">nom : </label>
            <input type="text" id="nom" name="nom">
            <br>
            <label for="prenom">Prénom : </label>
            <input type="text" id="prenom" name="prenom">
            <br>
            <label for="email">Email : </label>
            <input type="email" id="email" name="email">
            <br>
            <label for="telephone">Tél. : </label>
            <input type="text" id="telephone" name="telephone">
            <br>
            <label for="ddn">Date de naissance : </label>
            <input type="date" id="ddn" name="ddn">
            <br>
            <p class="label">Genre :</p>
            <input type="radio" value="F" id="genre_f" name="genre"><label for="genre_f">Féminin</label>
            <input type="radio" value="M" id="genre_h" name="genre"><label for="genre_h">Masculin</label>
            <br>
            <input type="hidden" name="insert_personne">
            <button>Insérer</button>
        </form>
    <?php endif;?>

    </main>
    <aside>
        <a href="listing.php">Retour</a>
    <?php if($nb_personnes > 0) : ?>
        <ul>
            <?php while ( $row = $q_personnes->fetch_object() ) :
            //print_r($row); ?>
                <li><a href="listing.php?id_personnes=<?php echo $row->id_personnes;?>"><?php echo $row->nom;?> <?php echo $row->prenom;?></a></li>
            <?php endwhile; ?>
        </ul>
    <?php else :
        echo "il n'y a personne";
    endif; ?>
    </aside>
    <footer></footer>
    <script src="main.js"></script>
    <script>
        Main();
    </script>
</body>
</html>

<?php print_r($_POST);?>