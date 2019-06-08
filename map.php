<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="imgs/favicon.ico" />
        <link rel="stylesheet" media="screen, print" href="style.css"/>
        <!--mappa-->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
        <title>Gioco d'azzardo - si può smettere</title>
    </head>
    <body>
        <header>
            <div id="header">
                <a href="index.html"><img src="imgs/logo.jpg" width="200" alt="logo"></a>
                
                <h1>DIPENDENZA DA GIOCO D'AZZARDO</h1>
            </div>
            <div id="navbar">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="recognize.html">Sintomi</a></li>
                    <li><a href="stop.html">Smettere</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a class="active" href="map.php">Mappa</a></li>
                    <li><a href="contactus.html">Contattaci</a></li>
                </ul>
            </div>
    </header>

    <div class="container">
        <div style="text-align:center">
            <h2>Punti di incontro</h2>
            <p>Incontra chi può capirti e aiutarti. Il primo passo spetta a te.</p>
        </div>
            <div id="mapid">
                <?php        
                    @include 'config.php';

                    $sql = "SELECT * FROM punti_incontro p JOIN comuni c ON p.id_comune = c.id";
                    $result = mysql_query($sql);
                    $num_results = mysql_num_rows($result);

                    $jsmap = "<script>
                    var mymap = L.map('mapid').setView([44.591949, 9.457293], 6);    //finestra della posizione della mappa

                    //Codice JavaScript per creare la mappa
                    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',
                        {
                            maxZoom: 18,
                            id: 'mapbox.streets'
                        }).addTo(mymap);
                        ";

                    

                    for ($i=0; $i < $num_results; $i++)
                    {
                        $row = mysql_fetch_array($result);
                        $str = "L.marker([" . $row[latitudine]. ", " . $row[longitudine] . "]).addTo(mymap).bindPopup('" . $row[nome_punti] . " - " . $row[telefono] . "');
                        ";
                        $jsmap .= $str;
                    }


                    $jsmap .= "</script>
                    ";

                print $jsmap;
                ?>
            </div>
    </div>
    
    <script>
        window.onload = getLocation();

        function getLocation()
        {
            //Browser supporta la posizione?
            if (navigator.geolocation) 
            {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            }
            else
            { 
                x.innerHTML = "Il browser non supporta la geolocalizzazione";
            }
        }

        //Gestisce gli error della posizione
        function showError(error) 
        {
            switch (error.code) 
            {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "Il permesso è stato negato."
                    break;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "Impossibile trovare la posizione."
                    break;
                case error.TIMEOUT: case error.UNKNOWN_ERROR:
                    x.innerHTML = "C'è stato un problema con la richiesta della posizione. Riprova."
                    break;
            }
        }
        
        function showPosition(position)
        {
            var youAreHere = L.icon(
            {
                iconUrl: 'imgs/you_are_here.png',
                shadowUrl: 'imgs/you_are_here-shadow.png',
                iconSize:     [25, 25],
                shadowSize:   [40, 40],
            });
	        L.marker([position.coords.latitude,position.coords.longitude], {icon: youAreHere}).addTo(mymap).bindPopup("Ti trovi qui");
        }
    </script>
    
    <footer>
        <div class="container">
            <p style="text-align: center">Copyright© 2019 - Nome società che non so.</p>
        </div>
    </footer>
    </body>
</html>