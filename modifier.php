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


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_animal_modifier"])) {
    $id_animal_modifier = $_POST["id_animal_modifier"];
    $sql_animal_modifier = "SELECT * FROM animaux WHERE id = $id_animal_modifier";
    $result_animal_modifier = $conn->query($sql_animal_modifier);
    if ($result_animal_modifier->num_rows > 0) {
        $row_animal_modifier = $result_animal_modifier->fetch_assoc();
    } else {
        echo "Aucun animal trouvé avec l'identifiant $id_animal_modifier";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier"])) {
    $id_animal = $_POST["id_animal"];
    $nom_animal = $_POST["nom_animal"];
    $date_naissance = $_POST["date_naissance"];
    $commentaire = $_POST["commentaire"];

    $sql_modification = "UPDATE animaux SET nom_animal='$nom_animal', date_de_naissance='$date_naissance', commentaire='$commentaire' WHERE id=$id_animal";

    if ($conn->query($sql_modification) === TRUE) {
        echo "L'animal a été modifié avec succès.";
    } else {
        echo "Erreur lors de la modification de l'animal : " . $conn->error;
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
    <title>Modifier animal</title>
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
    </style>
</head>
<body>


<div class="sidebar">
    <a href="dashboardanimauxpat.php">Dashboard</a>
    <a href="ajouter.php">Ajouter animal</a>
    <a href="modifier.php">Modifier animal</a>
    <a href="recherche.php">Rechercher animal</a>

    <center>
        <div class="logout-container">
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


    <h2>Modifier un animal</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="id_animal_modifier">ID de l'animal à modifier :</label>
        <input type="text" id="id_animal_modifier" name="id_animal_modifier" required><br><br>
        <input type="submit" value="Rechercher">
    </form>

    <?php if (isset($row_animal_modifier)): ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id_animal" value="<?php echo $row_animal_modifier['id']; ?>">
            <label for="nom_animal">Nom de l'animal :</label>
            <input type="text" id="nom_animal" name="nom_animal" value="<?php echo $row_animal_modifier['nom_animal']; ?>"><br><br>
            <label for="date_naissance">Date de naissance :</label>
            <input type="date" id="date_naissance" name="date_naissance" value="<?php echo $row_animal_modifier['date_de_naissance']; ?>"><br><br>
            <label for="commentaire">Commentaire :</label><br>
            <textarea id="commentaire" name="commentaire" rows="4" cols="50"><?php echo $row_animal_modifier['commentaire']; ?></textarea><br><br>
            <input type="submit" name="modifier" value="Modifier l'animal">
        </form>
    <?php endif; ?>
</div>

</body>
</html>
