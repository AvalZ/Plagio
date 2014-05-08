<?php

/*
 *     Copyright © 2014 Andrea Valenza <avalenza89@gmail.com>
 */

include_once './includes/util.php';
// Filtro l'url che viene mandato via POST
$url = filter_var($_POST["url"], FILTER_SANITIZE_URL);

// Crea l'array di token dalla pagina
$tokenArray = tokenize($url);

// Credenziali standard, possono essere modificate
// Gli argomenti sono in ordine: Host, UserName, Password, Database
$con = mysqli_connect("localhost", "plagio", "Plagio", "plagio");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

foreach ($tokenArray as $token) {
    echo $token;
    // Inserisce la frase e l'url a cui appartiene nel database
    $sql = "INSERT INTO frasi (source, frase) VALUES ('$url','$token')";
    if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con));
    }
}

// Sempre meglio chiudere la connessione
mysqli_close($con);
