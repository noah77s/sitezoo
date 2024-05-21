<?php
session_start();

// Connexion à la base de données (à remplacer par vos informations de connexion)
$servername = "localhost";
$username = "votre_nom_utilisateur";
$password = "votre_mot_de_passe";
$dbname = "tp_zoo";

// Création de la connexion
$conn = new mysqli("localhost","root","root","tp_zoo");

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer la liste des animaux depuis la base de données
$sql_animaux = "SELECT a.id, a.nom_animal, a.date_de_naissance, a.commentaire, e.nom_enclos, e.capacite_max
                FROM animaux a
                LEFT JOIN loc_animaux la ON a.id = la.id_animaux
                LEFT JOIN enclos e ON la.id_enclos = e.id";
$result_animaux = $conn->query($sql_animaux);

// Traitement de l'ajout d'un animal
// Traitement de l'ajout d'un animal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
    $nom_animal = $_POST["nom_animal"];
    $date_naissance = $_POST["date_naissance"];
    $commentaire = $_POST["commentaire"];
    

    $id_Especes = 1; 
    
    // Insertion dans la base de données
    $sql_ajout = "INSERT INTO animaux (nom_animal, date_de_naissance, commentaire, id_Especes) 
                  VALUES ('$nom_animal', '$date_naissance', '$commentaire', '$id_Especes')";
    if ($conn->query($sql_ajout) === TRUE) {
        // Rafraîchir la liste des animaux après l'ajout
        $result_animaux = $conn->query($sql_animaux);
    } else {
        echo "Erreur lors de l'ajout de l'animal : " . $conn->error;
    }
}


// Traitement de la suppression d'un animal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"])) {
    $id_animal = $_POST["id_animal"];

    // Suppression dans la base de données
    $sql_suppression = "DELETE FROM animaux WHERE id=$id_animal";
    if ($conn->query($sql_suppression) === TRUE) {
        // Rafraîchir la liste des animaux après la suppression
        $result_animaux = $conn->query($sql_animaux);
    } else {
        echo "Erreur lors de la suppression de l'animal : " . $conn->error;
    }
}

// Fermer la connexion
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
            background-color: rgba(255, 255, 255, 0.7); /* Couleur de fond avec opacité */
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

    <div class="counter-container">
        <h2>Nombre d'animaux</h2>
        <p><?php echo $result_animaux->num_rows; ?></p>
    </div>
    
        <h2>Animaux</h2>
        <?php if ($result_animaux->num_rows > 0): ?>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date de Naissance</th>
                    <th>Commentaire</th>
                    <th>Enclos</th>
                    <th>Capacité Max</th>
                </tr>
                <?php while ($row = $result_animaux->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["nom_animal"]; ?></td>
                        <td><?php echo $row["date_de_naissance"]; ?></td>
                        <td><?php echo $row["commentaire"]; ?></td>
                        <td><?php echo $row["nom_enclos"]; ?></td>
                        <td><?php echo $row["capacite_max"]; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Aucun animal trouvé.</p>
        <?php endif; ?>



    
        <h2>Supprimer un animal</h2>
        <div class="button-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="id_animal">ID de l'animal à supprimer:</label>
                <input type="text" id="id_animal" name="id_animal" required><br><br>
                <input type="submit" name="supprimer" value="Supprimer un animal">
            </form>
        </div>
    </div>
</div>

</body>
</html>
