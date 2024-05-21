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
        <center><h2>Bienvenue sur le dashboard !</h2></center>
        <center><h3>PASSIONER POUR PROTÉGER</h3></center>
        <div class="button-container">
        <form action="dashboardanimauxpat.php" method="post">
            <input type="submit" value="Dashboard animaux" class="style">
           
            <br><br>
       
       <div class="logout-container">
            <form action="logout.php" method="post">
                <input type="submit" value="Déconnexion" class="style">
            </form>
           
        </div>
    </div>
</body>
</html>
