<?php

/*
 *     Copyright © 2014 Andrea Valenza <avalenza89@gmail.com>
 */

require_once './vendor/simplehtmldom/simple_html_dom.php';
include_once './includes/util.php';


$con = new \mysqli("localhost", "plagio", "Plagio", "plagio");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = $con->query("SELECT * FROM frasi");

$poolFrasi = array();
$poolSource = array();
// Rimappa l'array dei risultati in due array associativi, uno con gli url
// sorgente, uno con le frasi. Hanno come campo comune la chiave, che
// corrisponde all'ID del record nel database
while ($row = $result->fetch_assoc()) {
    $key = $row['id'];
    $poolFrasi[$key] = $row['frase'];
    $poolSource[$key] = $row['source'];
}

$con->close();

// Pulisce l'url per evitare injection
$url = filter_var($_POST["url"], FILTER_SANITIZE_URL);

// Crea il DOM della pagina puntata da $url
$html = \file_get_html($url);

// Ricerca dei metatags keyword e description
// Questi dati possono essere usati per fare la ricerca della pool di testi
foreach ($html->find("meta") as $meta) {
    if ($meta->name == "keywords") {
        echo "Keywords: ";
        if ($meta->getAttribute("content") != "") {
            echo $meta->getAttribute("content");
            echo "<br/>";
        } else {
            echo "Keywords: ";
            echo "N/A" . "<br/>";
        }
    }


    if ($meta->name == "description") {
        echo "Description: ";
        if ($meta->getAttribute("content")) {
            echo $meta->getAttribute("content");
            echo "<br/>";
        } else {
            echo "Description: ";
            echo "N/A" . "<br/>";
        }
    }
}
echo "<br/><br/>";

// Crea l'array di token dalla pagina
$tokenArray = tokenize($url);
/**
 * Prepara la pagina aumentata.
 * La pagina viene creata manualmente; per lavori più complessi sarà necessario
 * usare una template engine.
 * Twig è già incluso nel progetto (vendor/twig), si consiglia di usarlo.
 */
echo '<html>'
 . '<head>'
 . '
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.min.css" rel="stylesheet"/>'
 . '</head>'
 . '<body>'
 . '<div class="container">';
echo '<div class = "panel-group" id = "accordion">';
$i = 1;
foreach ($tokenArray as $token) {
// array_search ritorna la key del valore trovato, false se non trova niente
// TODO: Sostituire con array_keys per avere match multipli
    $match = array_search($token, $poolFrasi);
    echo '<div class = "panel panel-default">
<div class = "panel-heading"';
    if ($match != false) {
// Se trova un match crea un link alla pagina di origine
        echo " style='background-color: rgba(255, 0, 0, 0.3);'";
    } else {
        echo " style='background-color: rgba(0, 255, 0, 0.3);'";
    }
    echo '>
<h4 class = "panel-title">
<a data-toggle = "collapse" data-parent = "#accordion" href = "#collapse' . $i . '">' . $token . '
</a>
</h4>
</div>
<div id = "collapse' . $i . '" class = "panel-collapse collapse in">
<div class = "panel-body">';
    if ($match != false) {
        // Se trova un match crea un link alla pagina di origine
        echo "<a href='$poolSource[$match]' alt='$poolSource[$match]'>$poolSource[$match]</a><br/>";
    } else {
        echo "Non ci sono corrispondenze.";
    }
    echo '</div>
</div>';

    echo '</div>';
    $i++;
}
echo '</div>';
echo '</div>';
echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>';
echo '<script src="js/bootstrap.js" type="text/javascript"></script>';
echo '<script type="text/javascript">$(document).ready( function(){$(".collapse").collapse();});</script>';
echo '</body>'
 . '</html>';
