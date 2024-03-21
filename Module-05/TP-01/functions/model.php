<?php
include_once 'security.php';
include_once 'service.php';

function dbConnect(){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=esiea_web', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }catch(Exception $e){
        throw new Exception('Erreur lors de la connexion à la base de données : ' . $e->getMessage());
    }
}   

function registerUser($nom, $prenom, $adresse, $email, $password, $confirmPassword) {
    $pdo = dbConnect();

    $defaultRole = 2; 

    functions\verifyCsrfToken();
    try {

        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {

            return "email_exists";
        } elseif ($password !== $confirmPassword) {

            return "password_mismatch";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, adresse, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $adresse, $email, $hashedPassword, $defaultRole]);
            return true;
        }
    } catch (Exception $e) {
        throw new Exception("Erreur lors de l'enregistrement de l'utilisateur : " . $e->getMessage());
    }
}

function loginUser($email, $password) {
    $pdo = dbConnect();

    try {

        $stmt = $pdo->prepare("SELECT id, email, password FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            return true;
        } else {

            return "wrong_email_password";
        }
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la connexion de l'utilisateur : " . $e->getMessage());
    }
}

function getUserInfos($id) {
    $pdo = dbConnect();

    try {

        $stmt = $pdo->prepare("SELECT id, nom, prenom, adresse, email FROM utilisateurs WHERE id = ?");
        $stmt->execute([$id]);
        $userInfo = $stmt->fetch();

        return $userInfo;
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la récupération des informations de l'utilisateur : " . $e->getMessage());
    }
}

function updateUserInfo($id, $nom, $prenom, $adresse, $email, $password, $confirmPassword){
    $pdo = dbConnect();

    functions\verifyCsrfToken();

    try {

        if($email === $_SESSION['email']){
            if ($password !== $confirmPassword) {
                return "password_mismatch";

            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, adresse = ?, email = ?, password = ? WHERE id = ?");
                $stmt->execute([$nom, $prenom, $adresse, $email, $hashedPassword, $id]);
                return true;
            }
        } else {
            $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                return "email_exists";

            } elseif ($password !== $confirmPassword) {
                return "password_mismatch";

            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, adresse = ?, email = ?, password = ? WHERE id = ?");
                $stmt->execute([$nom, $prenom, $adresse, $email, $hashedPassword, $id]);
                $_SESSION['email'] = $email;

                return true;
            }
        }

    } catch (Exception $e) {
        throw new Exception("Erreur lors de la modification des informations de l'utilisateur : " . $e->getMessage());
    }
}

function closeAccount($id) {
    $pdo = dbConnect(); 

    try {

        $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
        $stmt->execute([$id]);

        session_destroy();
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        throw new Exception("Erreur lors de la fermeture du compte de l'utilisateur : " . $e->getMessage());
    }
}
?>