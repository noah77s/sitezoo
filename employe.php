<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="aff.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
    .session1
    { border: 4px solid black;
        border-radius: 8px; 
        width: 30%; 
        margin-left: auto;
        margin-right: auto;
        color: black;
        margin-bottom:10px;
    }
</style>
</head>
<body bgcolor="green">
    <form action="projet.php" method="post">
        <div class="session1"><center><h1>Gestion des élèves</h1></center><br>
        <?php
        echo "<center>Bienvenue ".$_SESSION["login"]." vous êtes connecté en tant que ".$_SESSION ["fonction"]." </center>";
        ?>
        </div> <center><table>
            <tr><td>Identifiant:<input type="text" name="iden" class="style1"></td><td>Nom:<input type="text" name="name" class="style1"></td></tr>

            <tr></tr><td>Adresse:<input type="text" name="adr" class="style1"></td><td>Num de téléphone:<input type="tel" name="tele" class="style1"></td>
            <tr><td colspan="2"><input type="submit" value="valider" class="style"><input type="reset" value="annuler" class="style"></td></tr>
        </table></center>
        <br>
        <center><a href="aff.php">Afficher la liste</a></center><br>
        <center><a href="aff2.php">Afficher la liste 2</a></center><br>
        <center><a href="aff3.php">Affichage spéciale</a></center><br>
         <center><a href="aff4.php">Affichage spéciale</a></center><br>
        <center><a href="supprimer.php">Supprimer</a></center><br>
        <center><a href="rechercher.php">Rechercher</a></center><br>
        <center><a href="rechercher2.php">Rechercher 2</a></center><br>
        <?php
        echo '<center><a href="logout.php">Deconnexion</a></center>';
        ?>
    </div>
    

    </form>
</body>
</html>