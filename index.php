<?php 
    $bdd = new PDO('mysql:host=localhost;dbname=bdform', 'root', '');
    
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    echo 'Base de Donnée Connectée';

    $error = "";
    $charMax = 20;

    if(isset($_POST['valider'])){
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $age = $_POST['age'];
        if((empty($nom) || trim($nom) == '') || (empty($prenom) || trim($prenom) == '') || (empty($age) || trim($age) == ''))
            $error = "An attribute can't be empty";
        elseif(strlen($nom) > $charMax || strlen($prenom) > $charMax)
            $error = "An attrubute can't be more than 20 characters";
        else{
            $req = $bdd->prepare('INSERT INTO user(nom, prenom, age) VALUES(:nom, :prenom, :age)');
            
            $req->bindvalue(':nom', $nom);
            $req->bindvalue(':prenom', $prenom);
            $req->bindvalue(':age', $age);

            $result = $req->execute();

            if(!$result)
                echo "Erreur enregistrement";
            else {
                echo "
                <script type=\"text/javascript\"> 
                alert('Enregistrement reussi. Votre identifiant 
                est: " .$bdd->lastInsertId(). "')</script>";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Field checking in PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form name="fo" method="post" action="index.php">
        <fieldset>
            <legend>Test</legend>
            <label for="nom">Nom</label><br>
            <input type="text" name="nom" class="nom" value="<?php echo @$nom ?>" ><br>
            <label for="prenom">Prénom</label><br>
            <input type="text" name="prenom" class="prenom" value="<?php echo @$prenom ?>" ><br>
            <label for="age">Age</label><br>
            <input type="text" name="age" class="age" value="<?php echo @$age ?>" ><br>
            <input type="submit" name="valider" class="valider" value="Valider">
            <input type="reset" name="annuler" class="valider annuler" value="Effacer">
        </fieldset>
    </form>

    <?php if(!empty($error)) { ?>
    <div id="error">
        <?=$error?>
    </div>
    <?php } ?>
</body>
</html>