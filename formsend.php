<?php
/*
 Bestellung von Informationsmaterial, mit serverseitiger Formularvalidierung
 19.06.2020, Pius Senn

 Variante 1
 - Prüfen der Daten des Formulars info_bestellung_1.html
 - Bei Fehlern: Anzeigen von Fehlermeldungen, Anzeigen des Korrektur-Formulars
 - Wenn alles ok: Versenden der Daten per E-Mail, Anzeigen der Bestätigungsseite

 Besonderheiten der Lösung
 - Zahlreiche Wechsel zwischen HTML und PHP
 - Checkbox und Radiobutton kompliziert gelöst
 - nicht komfortabel konfigurierbar
 - Prüfen der E-Mail-Adresse mit RegEx
 Zusätzlich wird die nicht empfohlene Variante mit der Funktion filter_var() gezeigt
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="de-CH">

<head>
<title>Wirtschaftsgeschichte der Musikindustrie</title>
        <link rel="icon" type="img/png" href="icons/play.png">
        <link rel="stylesheet" href="startup.css">

</head>

<body>
<header>
        <div id="logo>"><img href="index.html" src="icons/play.png"></div>
        <h1>Wie Streamingplatformen die Musikindustrie verändert haben</h1>
    </header>
    <br>
    <br>
    <nav>
        <ul id="nav">
            <li style="background-color:#dddddd;"><a class="navbutton" href="index.html">Home</a></li>
            <li><a class="navbutton" href="damals.html">Musikindustrie damals</a></li>
            <li><a class="navbutton" href="spotify.html">Streaming</a></li>
            <li><a class="navbutton" href="profit.html">Wer profitiert?</a></li>
            <li><a class="navbutton" href="umfrage.html">Umfrage</a></li>
        </ul>
    </nav>

    <main>



    <?php

/*
    function yes()
    {
        echo  "<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">";


        echo  "<p>";
        echo      "<legend>Name*:</legend>";
        echo      "<label>";
        echo          "<input type=\"text\" name=\"name\" autofocus>";
        echo     "</label></p>";
        echo   "<br>";

        echo "<p>";
        echo   "<legend>Vorname*:</legend>";
        echo   "<label>";
        echo     "<input type=\"text\" name=\"vorname\" autofocus>";
        echo    "</label></p>";
        echo   "<br>";

        echo "<p>";
        echo   "<legend>E-Mail-Adresse*:</legend>";
        echo  "<label>";
        echo      "<input type=\"text\" name=\"email\" autofocus>";
        echo  "</label></p>";
        echo   "<br>";
        echo "<p>*-Pflichtfeld</p>";

        echo "<fieldset>";
        echo   "<legend>Ich bestelle Informationen zu</legend>";
        echo   "<p> <label>";
        echo         "<input type=\"checkbox\" name=\"infos[]\" value=\"PHP\">";
        echo       "PHP";
        echo   "</label></p>";
        echo   "<br>";
        echo  "<p> <label>";
        echo    "<input type=\"checkbox\" name=\"infos[]\" value=\"JavaScript\">";
        echo   "JavaScript";
        echo   "</label></p>";
        echo     "<br>";
        echo    "<p><label>";
        echo     "<input type=\"checkbox\" name=\"infos[]\" value=\"CSS\">";
        echo    "CSS";
        echo   "</label></p>";
        echo   "</fieldset>";

        echo   "<fieldset>";
        echo   "<legend>Ich abonniere den Newsletter</legend>";
        echo      "<p> <label>";
        echo   "<input type=\"radio\" name=\"newsletter\" value=\"Ja\">Ja";
        echo  "</label></p>";
        echo     "<br>";
        echo   "<p> <label>";
        echo   "<input type=\"radio\" name=\"neewsletter\" value=\"Nein\">Nein";
        echo     "</label></p>";
        echo   "</fieldset>";
        echo   "<input type=\"submit\" name=\"senden\" value=\"senden\">";
        echo  "</form>";
    }
echo yes();
*/
    // Fehlervariablen initialisieren, 0 = kein Fehler
    $fehlerName = 0;
    $fehlerWie=0;
    $fehlerWelche=0;


    // Request-Parameter bereinigen (Input-Sanitization)
    $name = htmlspecialchars($_POST['name']);


    // Pflichtfelder prüfen und bei Fehler die Fehlervariable setzen
    if ($name == '') {
        $fehlerName = 1;
    }


    //Auswahlliste prüfen
    if(htmlspecialchars($_POST['wie'])){
        $wieantwort=$_POST['wie'];
    }
    if(strstr($wieantwort, 'nichts')){
$fehlerWie=1;
    }

    if(htmlspecialchars($_POST['welche'])){
        $welcheantwort=$_POST['welche'];
    }
    if(strstr($welcheantwort, 'nichts')){
$fehlerWelche=1;
    }

    /*
65 Nicht empfohlene Variante mit der Funktion filter_var()
66 - Achtung: E-Mail-Adressen mit Umlauten werden bei dieser Variante abgelehnt!
67
68 if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
69 $fehlerEmail = 1;
70 }
-1-
form_test_send_1.php Freitag, 19. Juni 2020 14:03
71 */


    // Wenn ein oder mehrere Felder nicht ausgefüllt sind
    if ($fehlerName or $fehlerWie or $fehlerWelche) {
        
        // Fehlermeldungen ausgeben
        echo '<h2>Sie haben nicht alle Fragen vollständig ausgefüllt.</h2>';
        

        // Formular anzeigen
    ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" accept-charset="utf-8">
            <label for="name" class="bezeichnung">Name <span>
                </span></label>
            <br>
            <input type="text" class="text" name="name" id="name" value="<?php echo $name;
                                                                            ?>" >
                                                                            <br>
                                                                            <br>
                                                                            
                                                                            
<legend>Wie hören Sie am liebsten die Musik?</legend>


<?php
echo "<select name=\"wie\">";
if(strstr($wieantwort, 'nichts')){
    echo "<option value=\"nichts\" checked>";
}else{
    echo "<option value=\"nichts\">";
}

if(strstr($wieantwort, 'Streaming')){
    echo "<option value=\"Streaming\" checked>Streaming";
}else{
    echo "<option value=\"Streaming\">Streaming";
}

if(strstr($wieantwort, 'YouTube')){
    echo "<option value=\"YouTube\" checked>YouTube";
}else{
    echo "<option value=\"YouTube\">YouTube";
}

if(strstr($wieantwort, 'CDs')){
    echo "<option value=\"CDs\" checked>CDs";
}else{
    echo "<option value=\"CDs\">CDs";
}

if(strstr($wieantwort, 'Platten')){
    echo "<option value=\"Platten\" checked>Platten";
}else{
    echo "<option value=\"Platten\">Platten";
}

if(strstr($wieantwort, 'Kassetten')){
    echo "<option value=\"Kassetten\" checked>Kassetten";
}else{
    echo "<option value=\"Kassetten\">Kassetten";
}

if(strstr($wieantwort, 'anderes')){
    echo "<option value=\"anderes\" checked>anderes";
}else{
    echo "<option value=\"anderes\">anderes";
}
echo "</select>";


?>
<br>
<br>
<legend>Welche Musikrichtung gefällt Ihnen am meisten?</legend>


<?php
echo "<select name=\"welche\">";
if(strstr($wieantwort, 'nichts')){
    echo "<option value=\"nichts\" checked>";
}else{
    echo "<option value=\"nichts\">";
}

if(strstr($wieantwort, 'POP')){
    echo "<option value=\"POP\" checked>POP";
}else{
    echo "<option value=\"POP\">POP";
}

if(strstr($wieantwort, 'Rock')){
    echo "<option value=\"Rock\" checked>Rock";
}else{
    echo "<option value=\"Rock\">Rock";
}

if(strstr($wieantwort, 'Rap')){
    echo "<option value=\"Rap\" checked>Rap";
}else{
    echo "<option value=\"Rap\">Rap";
}

if(strstr($wieantwort, 'Schlager')){
    echo "<option value=\"Schlager\" checked>Schlager";
}else{
    echo "<option value=\"Schlager\">Schlager";
}

if(strstr($wieantwort, 'Klassische Musik')){
    echo "<option value=\"Klassische Musik\" checked>Klassische Musik";
}else{
    echo "<option value=\"Klassische Musik\">Klassische Musik";
}

if(strstr($wieantwort, 'anderes')){
    echo "<option value=\"anderes\" checked>anderes";
}else{
    echo "<option value=\"anderes\">anderes";
}
echo "</select>";


?>

        
<br>
<br>
            

            <input type="submit" name="send" value="senden" class="button">
            
        </form>
        
</body>
<?php
        // Endes des Formulars
    } else {
        // wenn alle Felder ausgefüllt sind, Mail senden und Bestätigung anzeigen

        // Mail-Inhalt aufbereiten
        

        // Mail senden
        /* mail(
            'meinname@meinprovider.ch',
            'Info-Bestellung (Formular)',
            $mailbody,
            "From:info@webpubli.ch\r\nContent-type: text/plain; charset=UTF-8",
            '-finfo@webpubli.ch'
        );
*/
?>
    <h2>Danke für Ihre Antworten</h2>
    <h3>Liebe/lieber <?php echo $name; ?>, danke für die Beantwortung der Fragen.</h3>
    <h3>So hören Sie am liebsten die Musik: <?php echo $wieantwort; ?> </h3>
    <h3>Hier noch ein paar spannende Fakten:</h3>
    <p>Im Jahr 2020 benutzten 57% der Befragten in Deutschland Musik-Streamingdienste, wie Spotify, Apple Musik oder Amazon Music.
2021 hörten 13% der Befragten in Deutschland Musik auf YouTube.
2021 hören in Deutschland 25.43 Millionen Leute regelmässig auf CD ihre Musik.
Im deutschsprachigen Raum hörten im Jahr 2017 34.87 Millionen Leute Musik über das Radio.
Heute hören nur noch 3.4 Millionen Leute in Deutschland auf Patten Musik
</p>
<p>Laut einer Umfrage ist Pop und Rock Musik die am weitesten verbreiteten Musik Genre und werden von 71.7% der Bevölkerung gehört.
    <br>
    Klassische Musik wird von 32.5% der Bevölkerung gehört.
    <br>
    Deuter Schlager wird von 47.7% der deutschen Bevölkerung gehört.
    <br>
    Hip-Hop wird von 28.6% der Befragten gehört.
    <br>
    Andere Genres wie Techno, Jazz und Volksmusik hören je etwa 25% der Befragten in der Umfrage.
</p>
<p></p>
<p></p>
<p></p>

    </body>
<?php
    } // Ende der Bestätigung
?>

</html>