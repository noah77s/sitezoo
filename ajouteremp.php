<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "tp_zoo";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer la liste des employés depuis la base de données
$sql_employes = "SELECT * FROM personnels";
$result_employes = $conn->query($sql_employes);

// Traitement de la suppression d'un employé
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"])) {
    $id_employe = $_POST["id_employe"];

    // Suppression dans la base de données
    $sql_suppression = "DELETE FROM personnels WHERE id=$id_employe";
    if ($conn->query($sql_suppression) === TRUE) {
        // Rafraîchir la liste des employés après la suppression
        $result_employes = $conn->query($sql_employes);
    } else {
        echo "Erreur lors de la suppression de l'employé : " . $conn->error;
    }
}

// Traitement de l'ajout d'un employé
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $salaire = $_POST["salaire"];
    $fonction = $_POST["fonction"];

    // Insertion dans la base de données
    $sql_ajout = "INSERT INTO personnels (nom, prenom, login, password, salaire, fonction) 
                  VALUES ('$nom', '$prenom', '$login', '$password', '$salaire', '$fonction')";
    if ($conn->query($sql_ajout) === TRUE) {
        // Rafraîchir la liste des employés après l'ajout
        $result_employes = $conn->query($sql_employes);
    } else {
        echo "Erreur lors de l'ajout de l'employé : " . $conn->error;
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

    <!-- Formulaire d'ajout d'un employé -->
    <h2>Ajouter un employé</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br><br>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required><br><br>
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br><br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="salaire">Salaire:</label>
        <input type="text" id="salaire" name="salaire" required><br><br>
        <label for="fonction">Fonction:</label>
        <select id="fonction" name="fonction">
            <option value="employe">Employé</option>
            <option value="patron">Patron</option>
        </select><br><br>
        <input type="submit" name="ajouter" value="Ajouter un employé">
    </form>

   
    <h2>Supprimer un employé</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="id_employe">ID de l'employé à supprimer:</label>
        <input type="text" id="id_employe" name="id_employe" required><br><br>
        <input type="submit" name="supprimer" value="Supprimer un employé">
    </form>
</body>
</html>
