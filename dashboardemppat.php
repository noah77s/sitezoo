<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "tp_zoo";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}


$sql_employes = "SELECT * FROM personnels";
$result_employes = $conn->query($sql_employes);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"])) {
    $id_employe = $_POST["id_employe"];


    $sql_suppression = "DELETE FROM personnels WHERE id=$id_employe";
    if ($conn->query($sql_suppression) === TRUE) {
       
        $result_employes = $conn->query($sql_employes);
    } else {
        echo "Erreur lors de la suppression de l'employé : " . $conn->error;
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
    <a href="dashboardemppat.php">Dashboard</a>
    <a href="ajouteremp.php">Ajouter employé</a>
    <a href="modifieremp.php">Modifier</a>
    <a href="rechercheemp.php">Rechercher employé</a>

  <center>  <div class="logout-container">
            <form action="logout.php" method="post">
                <input type="submit" value="Déconnexion" class="style">
            </form>
        </div>
 </center>

</div>

<div class="content">
    <div class="session1">
        <center><h1>Tableau de Bord Zoo</h1></center>
        <center><h2>Bienvenue <?php echo isset($_SESSION["login"]) ? htmlspecialchars($_SESSION["login"]) : "Utilisateur"; ?></h2></center>
    </div>

    <div class="counter-container">
        <h2>Nombre d'employés</h2>
        <p><?php echo $result_employes->num_rows; ?></p>
    </div>
 
        <h2>Employés</h2>
        <?php if ($result_employes->num_rows > 0): ?>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Login</th>
                    <th>Fonction</th>
                    <th>Salaire</th>
                </tr>
                <?php while ($row = $result_employes->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["nom"]; ?></td>
                        <td><?php echo $row["prenom"]; ?></td>
                        <td><?php echo $row["login"]; ?></td>
                        <td><?php echo $row["fonction"]; ?></td>
                        <td><?php echo $row["salaire"]; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Aucun employé trouvé.</p>
        <?php endif; ?>

    
        <h2>Supprimer un employé</h2>
        <div class="button-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="id_employe">ID de l'employé à supprimer:</label>
                <input type="text" id="id_employe" name="id_employe" required><br><br>
                <input type="submit" name="supprimer" value="Supprimer un employé">
            </form>
        </div>
    </div>
</div>

</body>
</html>
