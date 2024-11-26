<?php

function findUserDb($conn, $id) {
    // Escapa o ID para evitar SQL Injection
    $id = mysqli_real_escape_string($conn, $id);

    // Prepara a consulta SQL
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    // Verifica se a preparação da consulta falhou
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit('SQL error');
    }

    // Vincula o parâmetro (id) à consulta
    mysqli_stmt_bind_param($stmt, 'i', $id);
    // Executa a consulta
    mysqli_stmt_execute($stmt);

    // Obtém o resultado da consulta
    $result = mysqli_stmt_get_result($stmt);

    // Verifica se o resultado contém linhas
    if ($row = mysqli_fetch_assoc($result)) {
        $user = $row; // Se encontrar, atribui à variável $user
    } else {
        $user = null; // Se não encontrar, define como null
    }

    // Fecha a conexão
    mysqli_close($conn);
    // Retorna o usuário ou null caso não encontrado
    return $user;
}

function createUserDb($conn, $name, $email, $phone) {
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn,  $email);
    $phone = mysqli_real_escape_string($conn,  $phone);

    if($name && $email && $phone) {
        $sql = "INSERT INTO users (name, email, phone) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql))
            exit('SQL error');

        mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $phone);
        mysqli_stmt_execute($stmt);
        mysqli_close($conn);
        return true;
    }
}

function readUserDb($conn) {
    $users = [];

    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    $result_check = mysqli_num_rows($result);

    if($result_check > 0)
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($conn);
    return $users;
}

function updateUserDb($conn, $id, $name, $email, $phone) {
    if($id && $name && $email && $phone) {
        $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql))
            exit('SQL error');

        mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $phone, $id);
        mysqli_stmt_execute($stmt);
        mysqli_close($conn);
        return true;
    }
}

function deleteUserDb($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);

    if($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql))
            exit('SQL error');

        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        return true;
    }
}
