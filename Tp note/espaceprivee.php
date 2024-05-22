<?php
session_start();
include "connexion.php";

// Affichage de la salutation
$h = date('H');
$x = ($h >= 8 && $h < 18) ? "Bonjour" : "Bonsoir";

if (isset($_SESSION['login'])) {
    $username = $_SESSION['login'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $x .= " $nom $prenom";
}

$sql = 'SELECT * FROM stagiaire';
$stmt = $con->query($sql);
$stagaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Privé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .modifier, .supprimer {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php echo $x; ?>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de Naissance</th>
                <th>Photo Profil</th>
                <th>Filière</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
            <?php
            if (count($stagaires) > 0) {
                foreach ($stagaires as $stagaire) {
                    echo "<tr>
                       
                        <td>{$stagaire['nom']}</td>
                        <td>{$stagaire['prenom']}</td>
                        <td>{$stagaire['dateNaissance']}</td>
                        <td><img src='images/{$stagaire['idFiliere']}' alt='Photo de Profil' width='50'></td>
                        <td>{$stagaire['idFiliere']}</td>
                        <td class='modifier'><a href='ModifierStagiaire.php?id={$stagaire['idstagiaire']}'><img src='modifier_icon.jpg'  style='width: 15px; height: 15px; alt='Modifier'></a></td>
                        <td class='supprimer'><a href='supprimerStagiaire.php?id={$stagaire['idstagiaire']}'><img src='supprimer_icon.png' style='width: 15px; height: 15px;' alt='Supprimer'></a>
                        </td>
                      </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Aucun utilisateur trouvé</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
