
<?php
session_start();
include "connexion.php";

if (isset($_POST['ok'])) {
    $username = $_POST['login'];
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        echo "Les données d’authentification sont obligatoires.";
    } else {
        $sql = $con->prepare("SELECT * FROM compteadmin WHERE loginAdmin = :login AND motPasse = :password");
        $sql->execute([':login' => $username, ':password' => $password]);
        
        if ($sql->rowCount() > 0) {
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $_SESSION['login'] = $username;
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['prenom'] = $row['prenom'];
            header('Location: espaceprivee.php');
            exit();
        } else {
            echo "Les données d’authentification sont incorrectes.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page d'authentification</title>
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
        .container input[type="text"], .container input[type="password"] {
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
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Authentification</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="login">Login:</label>
            <input type="text" id="login" name="login">
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password">
            <input type="submit" value="S'authentifier" name="ok">
        </form>
    </div>
</body>
</html>

