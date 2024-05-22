<?php
session_start();
include "connexion.php";

// Vérifier si l'ID du stagiaire est passé en paramètre
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Assurez-vous d'utiliser le bon nom de colonne pour l'identifiant
    $sql = $con->prepare("SELECT * FROM stagiaire WHERE idstagiaire = :id");
    $sql->execute([':id' => $id]);
    $stagiaire = $sql->fetch(PDO::FETCH_ASSOC);

    // Si le stagiaire n'est pas trouvé, rediriger ou afficher un message
    if (!$stagiaire) {
        echo "Stagiaire non trouvé!";
        exit();
    }
} else {
    echo "ID du stagiaire non fourni!";
    exit();
}

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $dateNaissance = $_POST['dateNaissance'];
    $filiere = $_POST['filiere'];

    // Mettre à jour les informations du stagiaire dans la base de données
    $sql = $con->prepare("UPDATE stagiaire SET nom = :nom, prenom = :prenom, dateNaissance = :dateNaissance, filiere = :filiere WHERE idstagiaire = :id");
    $sql->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':dateNaissance' => $dateNaissance,
        ':filiere' => $filiere,
        ':id' => $id
    ]);

    // Rediriger après la mise à jour
    header("Location: espaceprivee.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Stagiaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .container h2 {
            background-color: #4f4f4f;
            color: white;
            padding: 15px 0;
            margin: -20px -20px 20px -20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #333;
        }
        .container input[type="text"], .container input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container input[type="submit"] {
            background-color: #f66b0e;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .container input[type="submit"]:hover {
            background-color: #e65c00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Modifier Stagiaire</h2>
        <form action="ModifierStagiaire.php?id=<?php echo $id; ?>" method="post">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($stagiaire['nom']); ?>" required>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($stagiaire['prenom']); ?>" required>
            <label for="dateNaissance">Date de Naissance:</label>
            <input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo htmlspecialchars($stagiaire['dateNaissance']); ?>" required>
            <label for="filiere">Filière:</label>
            <input type="text" id="filiere" name="filiere" value="<?php echo htmlspecialchars($stagiaire['idFiliere']); ?>" required>
            <input type="submit" value="Mettre à jour">
        </form>
    </div>
</body>
</html>
