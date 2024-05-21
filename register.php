<?php
session_start();
@include("connecte.php");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"]) && isset($_POST["password"])) {
    $a = $_POST["login"];
    $b = $_POST["password"];

    $_SESSION["login"] = $_POST["login"];
    $_SESSION["mot"] = $_POST["password"];

    $requete = "SELECT * FROM personnels WHERE login = ? AND password = ?";
    $statement = $conn->prepare($requete);
    $statement->bind_param("ss", $a, $b);
    $statement->execute();
    $resultat = $statement->get_result();
    $ligne = $resultat->num_rows;

    if ($ligne == 1) {
        $enreg = $resultat->fetch_assoc();
        $_SESSION["fonction"] = $enreg["fonction"];

        if ($enreg["fonction"] == "patron") {
            header("Location: dashboardpatron.php");
            exit();
        } else {
            header("Location: dashboardemp.php");
            exit();
        }
    } else {
        
        header("Location: userfail.html");
        exit();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["login"]) && isset($_POST["motdepasse"])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $login = $_POST['login'];
    $motdepasse = $_POST['motdepasse'];

    
    $requete = "INSERT INTO personnels (nom, prenom, login, password, salaire, fonction) VALUES (?, ?, ?, ?, 0, 'employe')";
    $statement = $conn->prepare($requete);
    $statement->bind_param("ssss", $nom, $prenom, $login, $motdepasse);


    if ($statement->execute()) {
        
        $requete_fonction = "SELECT fonction FROM personnels WHERE login = ?";
        $statement_fonction = $conn->prepare($requete_fonction);
        $statement_fonction->bind_param("s", $login);
        $statement_fonction->execute();
        $resultat_fonction = $statement_fonction->get_result();
        $ligne_fonction = $resultat_fonction->fetch_assoc();
    
        if ($resultat_fonction->num_rows == 1) {
           
            if ($ligne_fonction['fonction'] == "patron") {
                header("Location: dashboardpatron.php");
                exit();
            } else if ($ligne_fonction['fonction'] == "employe") {
                header("Location: dashboardemp.php");
                exit();
            }
        } else {
            
            header("Location: userfail.html");
            exit();
        }
    } else {
        
        header("Location: userfail.html");
        exit();
    }
}
?>
