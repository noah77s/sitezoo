<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="aff.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'employé</title>
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
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid black;
}

th, td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
    color: black;
}

/* CSS pour les boutons */
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
    <a href="dashboardemppat.php">Dashboard</a>
    <a href="ajouteremp.php">Ajouter employé</a>
    <a href="modifieremp.php">Modifier</a>
    <a href="rechercheemp.php">Rechercher employé</a>
</div>

<div class="content">
    <h1>Recherche d'employé</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <label for="id_recherche">ID de l'employé à rechercher :</label><br>
        <input type="text" id="id_recherche" name="id_recherche" required><br><br>
        <input type="submit" name="rechercher" value="Rechercher">
    </form>
    
   <center>
    <?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "tp_zoo";

    $conn = new mysqli("localhost","root","root","tp_zoo");

    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["rechercher"])) {
        $id_recherche = $_GET["id_recherche"];

        $sql_recherche = "SELECT * FROM personnels WHERE id = $id_recherche";
        $result_recherche = $conn->query($sql_recherche);

        if ($result_recherche->num_rows > 0) {
            echo "<h2>Résultat de la recherche</h2>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Login</th><th>Fonction</th><th>Salaire</th></tr>";
            while ($row_recherche = $result_recherche->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_recherche["id"] . "</td>";
                echo "<td>" . $row_recherche["nom"] . "</td>";
                echo "<td>" . $row_recherche["prenom"] . "</td>";
                echo "<td>" . $row_recherche["login"] . "</td>";
                echo "<td>" . $row_recherche["fonction"] . "</td>";
                echo "<td>" . $row_recherche["salaire"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Aucun employé trouvé avec l'identifiant $id_recherche</p>";
        }
    }

    $conn->close();
    ?> </center>
</div>

</body>
</html>
