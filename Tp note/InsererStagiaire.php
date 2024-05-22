
<?php
// Inclure la connexion à la base de données
require 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $filiere_id = $_POST['filiere'];

    // Gestion de l'upload de l'image
    $photo_profil = $_FILES['photo_profil']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($photo_profil);

    // Vérifier si le fichier a été correctement déplacé
    if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $target_file)) {
        // Insertion des données dans la base de données
        $sql = 'INSERT INTO utilisateurs (nom, prenom, date_naissance, photo_profil, filiere) VALUES (:nom, :prenom, :date_naissance, :photo_profil, :filiere_id)';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':date_naissance', $date_naissance);
        $stmt->bindParam(':photo_profil', $photo_profil);
        $stmt->bindParam(':filiere_id', $filiere_id);

        if ($stmt->execute()) {
            header('Location: espaceprivee.php');
            exit();
        } else {
            echo 'Erreur lors de l\'insertion du stagiaire.';
        }
    } else {
        echo 'Erreur lors du téléchargement de l\'image.';
    }
}

// Récupérer les filières pour la liste déroulante
$sql = 'SELECT * FROM filiere';
$stmt = $con->prepare($sql);
$stmt->execute();
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Stagiaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="file"],
        select {
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ajouter un Stagiaire</h2>
        <form action="InsererStagiaire.php" method="post" enctype="multipart/form-data">
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="nom" required>

            <label for="prenom">Prénom:</label>
            <input type="text" name="prenom" id="prenom" required>

            <label for="date_naissance">Date de Naissance:</label>
            <input type="date" name="date_naissance" id="date_naissance" required>

            <label for="photo_profil">Photo Profil:</label>
            <input type="file" name="photo_profil" id="photo_profil" required>

            <label for="filiere">Filière:</label>
            <select name="filiere" id="filiere" required>
                <?php foreach ($filieres as $filiere): ?>
                    <option value="<?php echo $filiere['id']; ?>"><?php echo $filiere['nom']; ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" name="ajouter" value="Ajouter">
        </form>
        <a href="espaceprivee.php" class="back-link">Retour</a>
    </div>
</body>
</html>
```

<!-- ### Explications supplémentaires :

1. **PHP pour insérer le stagiaire** : Le traitement PHP est placé en haut du fichier `InsererStagiaire.php`, avant le HTML. Ce script traite le formulaire lorsqu'il est soumis.
2. **Formulaire HTML** : Le formulaire HTML et le CSS sont en dessous du traitement PHP. Il affiche le formulaire d'ajout de stagiaire et récupère dynamiquement les filières depuis la base de données.
3. **Structure et style** : Le formulaire est stylisé pour ressembler à celui de l'image fournie. Les styles incluent des bordures arrondies, des ombres, et des marges appropriées pour une meilleure lisibilité.

En plaçant le traitement PHP en haut du fichier, nous nous assurons que toutes les actions nécessaires sont effectuées avant que le formulaire soit affiché à l'utilisateur. Si le formulaire est soumis, le traitement PHP gère l'insertion du stagiaire et la redirection appropriée. -->