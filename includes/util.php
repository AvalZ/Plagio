<?php

/*
 *  Copyright (C) 2014 Andrea Valenza <avalenza89@gmail.com>
 */


// ATTENZIONE: dal momento che questo file viene incluso in ProcessAndSearch.php
// e in upload.php, il path di require_once deve essere relativo al punto in cui
// viene incluso.
require_once './vendor/simplehtmldom/simple_html_dom.php';

/**
 * Crea la lista di token a partire dalla pagina puntata da $url
 * @param string $url Deve essere un URL valido
 * @return array<string> La lista dei token estratti
 */
function tokenize( $url )
{

// Creo il DOM della pagina indicata da $url
    $html = \file_get_html( $url );
// Elimino tutti i tag dalla pagina
// ->plaintext è il parser html, se uso un altro formato devo sostituire il parser
    $textWithoutTags = $html->plaintext;

// Elimino tutti gli spazi ripetuti e li sostituisco con uno solo
    $textWithoutTags = \preg_replace( '!\s+!', ' ', $textWithoutTags );
// Creo un array dividendo il testo ogni volta che trovo un punto
    $tokens = \explode( ".", $textWithoutTags );


// Applico la funzione "trim_value" ad ogni elemento di $nodesArray
    \array_walk( $tokens, "trim_value" );
// Filtro nodesArray con il risultato della funzione "strlen". Il risultato è
// eliminare i valori vuoti dentro a $nodesArray.
    $tokens = \array_filter( $tokens, "strlen" );

    return $tokens;
}

/**
 * La funzione "trim" passa per valore, ho bisogno della stessa funzione, ma
 * devo passare per riferimento.
 *
 * @param string $value Viene passato per riferimento, quindi non serve return
 */
function trim_value( &$value )
{
    $value = \trim( $value );
}
