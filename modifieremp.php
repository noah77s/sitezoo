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


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_employe_modifier"])) {
    $id_employe_modifier = $_POST["id_employe_modifier"];
    $sql_employe_modifier = "SELECT * FROM personnels WHERE id = $id_employe_modifier";
    $result_employe_modifier = $conn->query($sql_employe_modifier);
    if ($result_employe_modifier->num_rows > 0) {
        $row_employe_modifier = $result_employe_modifier->fetch_assoc();
    } else {
        echo "Aucun employé trouvé avec l'identifiant $id_employe_modifier";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier"])) {
    $id_employe = $_POST["id_employe"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $login = $_POST["login"];
    $fonction = $_POST["fonction"];
    $salaire = $_POST["salaire"];

    $sql_modification = "UPDATE personnels SET nom='$nom', prenom='$prenom', login='$login', fonction='$fonction', salaire='$salaire' WHERE id=$id_employe";

    if ($conn->query($sql_modification) === TRUE) {
        echo "L'employé a été modifié avec succès.";
    } else {
        echo "Erreur lors de la modification de l'employé : " . $conn->error;
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
    <title>Modifier employé</title>
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
    <a href="dashboardemppat.php">Dashboard</a>
    <a href="ajouteremp.php">Ajouter employé</a>
    <a href="modifieremp.php">Modifier</a>
    <a href="rechercheemp.php">Rechercher employé</a>

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
        <center><h1>Tableau de Bord Zoo</h1></center>
        <center><h2>Bienvenue <?php echo isset($_SESSION["login"]) ? htmlspecialchars($_SESSION["login"]) : "Utilisateur"; ?></h2></center>
    </div>

    
    <h2>Modifier un employé</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="id_employe_modifier">ID de l'employé à modifier :</label>
        <input type="text" id="id_employe_modifier" name="id_employe_modifier" required><br><br>
        <input type="submit" value="Rechercher">
    </form>

    <?php if (isset($row_employe_modifier)): ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id_employe" value="<?php echo $row_employe_modifier['id']; ?>">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo $row_employe_modifier['nom']; ?>"><br><br>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo $row_employe_modifier['prenom']; ?>"><br><br>
            <label for="login">Login :</label>
            <input type="text" id="login" name="login" value="<?php echo $row_employe_modifier['login']; ?>"><br><br>
            <label for="fonction">Fonction :</label>
            <input type="text" id="fonction" name="fonction" value="<?php echo $row_employe_modifier['fonction']; ?>"><br><br>
            <label for="salaire">Salaire :</label>
            <input type="text" id="salaire" name="salaire" value="<?php echo $row_employe_modifier['salaire']; ?>"><br><br>
            <input type="submit" name="modifier" value="Modifier l'employé">
        </form>
    <?php endif; ?>
</div>

</body>
</html>
