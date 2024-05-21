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


$sql_animaux = "SELECT a.id, a.nom_animal, a.date_de_naissance, a.commentaire, e.nom_enclos, e.capacite_max
                FROM animaux a
                LEFT JOIN loc_animaux la ON a.id = la.id_animaux
                LEFT JOIN enclos e ON la.id_enclos = e.id";
$result_animaux = $conn->query($sql_animaux);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
    $nom_animal = $_POST["nom_animal"];
    $date_naissance = $_POST["date_naissance"];
    $commentaire = $_POST["commentaire"];
    $nom_enclos = $_POST["nom_enclos"];
    $id_personnel = $_POST["id_personnel"];
    
  
    $id_Especes = 1; 
    
   
    $sql_ajout = "INSERT INTO animaux (nom_animal, date_de_naissance, commentaire, id_Especes) 
                  VALUES ('$nom_animal', '$date_naissance', '$commentaire', '$id_Especes')";
    if ($conn->query($sql_ajout) === TRUE) {
   
        $result_animaux = $conn->query($sql_animaux);
    } else {
        echo "Erreur lors de l'ajout de l'animal : " . $conn->error;
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"])) {
    $id_animal = $_POST["id_animal"];

   
    $sql_suppression = "DELETE FROM animaux WHERE id=$id_animal";
    if ($conn->query($sql_suppression) === TRUE) {
       
        $result_animaux = $conn->query($sql_animaux);
    } else {
        echo "Erreur lors de la suppression de l'animal : " . $conn->error;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="aff.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Zoo</title>
    <style type="text/css">
        .session1 {
            border: 4px solid black;
            border-radius: 8px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            color: black;
            margin-bottom: 10px;
            background-color: rgba(255, 255, 255, 0.7); 
            padding: 20px;
        }
        .button-container {
            text-align: center;
        }
        .button-container input[type="submit"] {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
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

        /* CSS pour styliser le tableau */
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
        <center><h1>Tableau de Bord Animaux</h1></center>
        <center><h2>Bienvenue <?php echo isset($_SESSION["login"]) ? htmlspecialchars($_SESSION["login"]) : "Utilisateur"; ?></h2></center>
    </div>


    <h2>Ajouter un animal</h2>
    <div class="button-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="nom_animal">Nom de l'animal:</label>
            <input type="text" id="nom_animal" name="nom_animal" required><br><br>
            <label for="date_naissance">Date de naissance:</label>
            <input type="date" id="date_naissance" name="date_naissance" required><br><br>
            <label for="commentaire">Commentaire:</label><br>
            <textarea id="commentaire" name="commentaire" rows="4" cols="50"></textarea><br><br>

            <label for="nom_enclos">Nom de l'enclos:</label>
            <input type="text" id="nom_enclos" name="nom_enclos" required><br><br>
            <label for="id_personnel">ID du personnel:</label>
            <input type="text" id="id_personnel" name="id_personnel" required><br><br>
            
            <input type="submit" name="ajouter" value="Ajouter un animal">
        </form>
    </div>

   
    <h2>Supprimer un animal</h2>
    <div class="button-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="id_animal">ID de l'animal à supprimer:</label>
            <input type="text" id="id_animal" name="id_animal" required><br><br>
            <input type="submit" name="supprimer" value="Supprimer un animal">
        </form>
    </div>
</div>

</body>
</html>
