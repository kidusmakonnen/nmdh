<?php
/**
 * User: kidus
 * Date: 3/3/19
 * Time: 2:43 PM
 */
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
} else {
    require_once "../Models/AccountManagement.php";
    $username = $_SESSION["username"];
    $password = $_POST["password"];
    $new_password = $_POST["newPassword"];
    $new_password2 = $_POST["newPassword2"];

    if ($new_password !== $new_password2) {
        header("Location: ../developer/preferences.php?matchError");
        return;
    }

    if (AccountManagement::passwordValid($username, $password)) {
        $user = AccountManagement::getUser($username);

        $user->setPassword($new_password);

        AccountManagement::updateUser($user);

        header("Location: ../developer/preferences.php?success");
    } else {
        header("Location: ../developer/preferences.php?error");
    }
}