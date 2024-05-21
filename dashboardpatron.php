<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="dashboard.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .button-container {
            text-align: center;
        }

        .button-container input[type="submit"],
        .button-container a {
            margin: 0 10px; 
        }
    </style>
</head>
<body>
    <div class="imagefond"></div>
    <center><h1 class="ombretexte">ZOO</h1></center>
    <div class="login-box">
    <?php
       
        session_start();

        
        if(isset($_SESSION["login"]) && isset($_SESSION["fonction"])) {
            
            echo "<center>Bienvenue ".$_SESSION["login"]." vous êtes connecté en tant que ".$_SESSION["fonction"]." </center>";
        } else {
           
            echo "<center>Veuillez vous connecter.</center>";
           
        }
    ?>
        <center><h3>PASSIONER POUR PROTÉGER</h3></center>
        
        <div class="button-container">
        <form action="dashboardanimauxpat.php" method="post">
            <input type="submit" value="Dashboard animaux" class="style">
    </form>
           
            <form action="dashboardemppat.php" method="post">
            <input type="submit" value="Dashboard employés" class="style">
        </form>
       
        <div class="logout-container">
            <form action="logout.php" method="post">
                <input type="submit" value="Déconnexion" class="style">
            </form>
        </div>

    
</body>
</html>
