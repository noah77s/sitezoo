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
        .session1 {
            border: 4px solid black;
            border-radius: 8px;
            width: 30%;
            margin-left: auto;
            margin-right: auto;
            color: black;
            margin-bottom: 10px;
            background-color: rgba(255, 255, 255, 0.7); /* Couleur de fond avec opacité */
            padding: 20px;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 25px;
            text-decoration: none;
            font-size: 20px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            color: #f1f1f1;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>


<div class="sidebar">
  
    <a href="#" onclick="loadDashboardAnimaux()">Dashboard</a>
</div>

<div class="content">
        <div class="session1">
            <center><h1>Gestion des élèves</h1></center><br>
            <?php
            echo "<center>Bienvenue ".$_SESSION["login"]." vous êtes connecté en tant que ".$_SESSION["fonction"]." </center>";
            ?>
        </div>
    


    <div id="dashboard-container"></div>

    <script>

        function loadDashboardAnimaux() {
            
            var dashboardContainer = document.getElementById("dashboard-container");

            
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    dashboardContainer.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "dashboardemploye.php", true);
            xhttp.send();
        }
    </script>
</div>
</body>
</html>
