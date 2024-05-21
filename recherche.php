<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="aff.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Zoo</title>
    <style type="text/css">
        .imagefond {
           
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
            text-align: center; 
        }
        .content h1 {
            margin-bottom: 20px; 
        }
        .content form {
            display: inline-block; 
            text-align: center; 
        }

        table {
    width: 50%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid black;
}

th, td {
    padding: 8px;
    text-align: center;
}

th {
    background-color: #f2f2f2;
    color: black;
}


.button-container input[type="submit"] {
    margin: 10px;
    padding: 10px 20px;
    font-size: 16px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.button-container input[type="submit"]:hover {
    background-color: #45a049;
}


    </style>
</head>
<body>


<div class="sidebar">
    <a href="dashboardanimauxpat.php">Dashboard</a>
    <a href="ajouter.php">Ajouter animal</a>
    <a href="modifier.php">Modifier animal</a>
    <a href="recherche.php">Rechercher animal</a>

  <center>  <div class="logout-container">
            <form action="logout.php" method="post">
                <input type="submit" value="Déconnexion" class="style">
            </form>
        </div>
 </center>

</div>

<div class="content">
    <div class="session1">
        <center><h1>Rechercher un animal</h1></center>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <label for="id_recherche">ID de l'animal à rechercher :</label>
        <input type="text" id="id_recherche" name="id_recherche" required><br><br>
        <input type="submit" name="rechercher" value="Rechercher">
    </form>
</div>

<center> <?php
session_start();


$servername = "localhost";
$username = "votre_nom_utilisateur";
$password = "votre_mot_de_passe";
$dbname = "tp_zoo";


$conn = new mysqli("localhost","root","root","tp_zoo");


if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["rechercher"])) {
    $id_recherche = $_GET["id_recherche"];


    $sql_recherche = "SELECT a.id, a.nom_animal, a.date_de_naissance, a.commentaire, e.nom_enclos, e.capacite_max
                      FROM animaux a
                      LEFT JOIN loc_animaux la ON a.id = la.id_animaux
                      LEFT JOIN enclos e ON la.id_enclos = e.id
                      WHERE a.id = $id_recherche";
    $result_recherche = $conn->query($sql_recherche);



    if ($result_recherche->num_rows > 0) {
        echo "<h2>Résultat de la recherche</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Date de Naissance</th><th>Commentaire</th><th>Enclos</th><th>Capacité Max</th></tr>";
        while ($row_recherche = $result_recherche->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row_recherche["id"] . "</td>";
            echo "<td>" . $row_recherche["nom_animal"] . "</td>";
            echo "<td>" . $row_recherche["date_de_naissance"] . "</td>";
            echo "<td>" . $row_recherche["commentaire"] . "</td>";
            echo "<td>" . $row_recherche["nom_enclos"] . "</td>";
            echo "<td>" . $row_recherche["capacite_max"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun animal trouvé avec l'identifiant $id_recherche</p>";
    }
}


$conn->close();
?>
</center>

</body>
</html>
