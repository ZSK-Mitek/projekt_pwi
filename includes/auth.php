<?php
function registerUser($username, $email, $password) {
    global $link;
    $query_check_existing = "SELECT id FROM users WHERE username = ? OR email = ?";
    if ($stmt_check = mysqli_prepare($link, $query_check_existing)) {
        mysqli_stmt_bind_param($stmt_check, "ss", $username, $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            return false;
        }
        mysqli_stmt_close($stmt_check);
    }
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);
        if (mysqli_stmt_execute($stmt)) {
            return true;
        }
        mysqli_stmt_close($stmt);
    }
    return false;
}

function loginUser($username, $password) {
    global $link;
    $query = "SELECT id, password FROM users WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $hashed_password);
            mysqli_stmt_fetch($stmt);
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                return true;
            }
        }
        mysqli_stmt_close($stmt);
    }
    return false;
}
?>