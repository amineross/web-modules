<?php

function handleRegisterAction() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        functions\verifyCsrfToken();

        $nom = functions\sanitizeInput($_POST['nom']);
        $prenom = functions\sanitizeInput($_POST['prenom']);
        $adresse = functions\sanitizeInput($_POST['adresse']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        $errors = functions\validateRegistrationForm($nom, $prenom, $adresse, $email, $password, $confirmPassword);

        if (!empty($errors)) {

            $data['errors'] = $errors;
            include_once 'templates/register.php';
        } else {

            $error = registerUser($nom, $prenom, $adresse, $email, $password, $confirmPassword);

            if ($error === true) {
                header("Location: index.php?action=login");
                exit();
            } else {

                $data['error'] = $error;
                include_once 'templates/register.php';
            }
        }
    } else {

        include_once 'templates/register.php';
    }
}

function handleLoginAction() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        functions\verifyCsrfToken();

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $error = loginUser($email, $password);

        if($error === true){
            header("Location: index.php?action=dashboard");
            exit();
        } else {
            include_once 'templates/login.php';
        }
    } else {
        include_once 'templates/login.php';
    }
}

function handleUpdateAction() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        \functions\verifyCsrfToken();

        $id = $_SESSION['user_id'];
        $nom = functions\sanitizeInput($_POST['nom']);
        $prenom = functions\sanitizeInput($_POST['prenom']);
        $adresse = functions\sanitizeInput($_POST['adresse']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        $errors = functions\validateRegistrationForm($nom, $prenom, $adresse, $email, $password, $confirmPassword);

        if (!empty($errors)) {
            $data['errors'] = $errors;
            include_once 'templates/update.php';
        } else {

            $error = updateUserInfo($id, $nom, $prenom,$adresse, $email, $password, $confirmPassword);

            if ($error === true) {
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                include_once 'templates/update.php';
            }
        }

    } else {
        include_once 'templates/update.php';
    }
}

function handleCloseAction() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_SESSION['user_id'];

        functions\verifyCsrfToken();

        closeAccount($id);

        session_destroy();

        header("Location: index.php");
        exit();
    }
}

function handleLogoutAction() {

    session_destroy();

    header("Location: index.php");
    exit();
}

?>