<?php

require_once 'model.php';
include_once 'security.php';
include_once 'service.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();    
}

function controller() {
    try{

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_GET['action'])) {
        $action = $_GET['action'];        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            functions\verifyCsrfToken();
        }

        switch ($action) {
            case 'register':
                handleRegisterAction();
                break;
            case 'login':
                handleLoginAction();
                break;
            case 'dashboard':
                include_once 'templates/dashboard.php';
                break;
            case 'update':
                handleUpdateAction();
                break;
            case 'close':
                handleCloseAction();
                break;
            case 'logout':
                handleLogoutAction();
                break;
            default:
                include_once 'templates/home.php';
                break;
        }
    } else {
        include_once 'templates/home.php';
    }
}catch(Exception $e){
    $error_message = $e->getMessage();
    require_once 'templates/error.php';
}
}

?>