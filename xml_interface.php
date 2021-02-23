<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <p>Suchmaschine</p>
    <form action="index.php" method="get">
      Suche: <input type="text" name="search" placeholder="Bitte geben Sie Ihren Suchbegriff ein">
      <button type="submit">Suchen</button>
      <p></p>
      Anzahl der Ergebnisse: <input type="number" name="anzahl">

      <?php
      $search = $_GET["search"];
      $anzahl = $_GET["anzahl"];
      $ip = $_SERVER["REMOTE_ADDR"];
      $agent = get_browser(null, true);

      if (isset($anzahl)) {
        #https://qualigo.com/doks/search.php?ds=websucde&m=de&count=3&query=test&subds=trusteddomainname.com&ip=77.22.198.50&agent=UserAgen&prnt_ref=test"
        #1.Schritt: Korrekte URL generieren
        $data = array(
            'ds' => 'websucde',
            'count' => $anzahl,
            'query' => $search,
            'subds'=> 'trusteddomainname.com',
            'ip' =>  $ip,
            'agent' => $agent
        );
        $full_url =  "https://qualigo.com/doks/search.php" .'?'. http_build_query($data);

        #2. Anfrage Senden
        $raw_xml = file_get_contents($full_url);

        #3. Respone bearbeiten
        $data = new SimpleXMLElement($raw_xml);

        #4. Daten Anzeigen
        foreach($data->RANK as $ergebnis){
          $gesamtbetrag += ($ergebnis->PRODUCTPRICE/100);
          echo "<br>";
          echo '<img src="'. $ergebnis->PREVIEWURL . '"style="float:left" width="190" height="84" />"';
          echo $ergebnis->TITLE . "<br>";
          echo $ergebnis->ABSTRACT . "<br>";
          echo '<a href="' . $ergebnis->URL . '">Zum Angebot</a>' . '<br>';
          echo "<p></p>";
        }
          echo 'Gesamtbetrag"' . $gesamtbetrag . '"';
      }
      else {
        echo "Bitte geben Sie die Anzahl der Treffer ein";
      }
      ?>
    </form>
  </body>
</html>
