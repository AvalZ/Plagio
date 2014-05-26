Plagio
======

Progetto sul Plagio di articoli scientifici
-------------------------------------------

[![Gitter chat](https://badges.gitter.im/AvalZ/Plagio.png)](https://gitter.im/AvalZ/Plagio)

### Requisiti:
1. Database MySQL con nome **plagio**
2. *Utente* **plagio** con *password* **Plagio** e privilegi di lettura e scrittura sul Database
3. Tabella chiamata **frasi** con queste colonne:
  + **id** *int*, PK e AI
  + **frase** *TEXT*
  + **source** *TEXT*


### Primo avvio:
*(Si suppone che il progetto si trovi all'indirizzo [http://localhost/Plagio/](http://localhost/Plagio/))*

Oltre ai form e agli script, sono presenti 4 file nel progetto:
1. [pool1.html](http://localhost/Plagio/tempPool/pool1.html)
2. [pool2.html](http://localhost/Plagio/tempPool/pool2.html)
3. [pool3.html](http://localhost/Plagio/tempPool/pool3.html)
4. [prova.html](http://localhost/Plagio/prova.html)
I primi 3 sono file che verrebbero caricati in automatico nel *Pool* di testi, il quarto è l'articolo che dobbiamo controllare.


1. Entrare nel [pannello di upload](http://localhost/Plagio/admin.html) e inserire l'url completo di [pool1.html](http://localhost/Plagio/tempPool/pool1.html), attendere il caricamento.
2. Ripetere per gli altri testi nella pool (__NON__ per prova.html, altrimenti sarà sempre positivo)
3. Entrare nel [pannello principale](http://localhost/Plagio/index.html) e inserire l'url completo di [prova.html](http://localhost/Plagio/prova.html).
4. Ogni frase apparirà stampata a schermo come *frase semplice* nel caso non venga trovata corrispondenza, oppure come *link ipertestuale* nel caso venga trovata. Notare che cliccando sul link si viene reindirizzati alla pagina dalla quale è stata copiata la frase.
