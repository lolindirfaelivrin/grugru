<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentazione</title>
    <link rel="stylesheet" href="./css/ossicino.min-0.2.css">
</head>
<body data-bianco>
    <nav>
        <ul data-accento="false">
            <li><a href="/">Home</a></li>
            <li><a href="/documentazione">Documentazione</a></li>
        </ul>
        <h2>Documentazione</h2>  
        <ul data-accento="false">
            <li><a href="/errori">Errori</a></li>
            <li><a href="/versioni">Versioni</a></li>
            <li><a href="/contattami">Contattami</a></li>
        </ul>
    </nav>
    <section>
        <ul>
            <li>Router</li>
            <li>Request</li>
            <li>Response</li>
            <li>Controller</li>
            <li><a href="/validazione">Validazione</a></li>
            <li><a href="/configurazione">Configurazione</a></li>
        </ul>
    </section>

    <section>
        <h2>Struttura delle Disrectory</h2>
        <p>La struttura delle Disrectory è molto importante, il framework <strong>GruGru</strong> utilizza questa distribubione dei file e delle cartelle</p>
        <h3>Cartella src</h3>
        <p>In questa cartella sono contenuti tutte le classi create dall'utente</p>
        <h3>Cartella views</h3>
        <p>Qui sono presenti i file delle viste, la documentazione del framework e la pagina principale. Ovviamente tutti i file possono essere
            gestiti in autonomia.
        </p>
    </section>

    <section>
        <h2>Request</h2>
        <p>
            La classe <b>Request</b> &egrave; deputata per elaborare le richieste del server. Dispone dei seguienti metodi:
        </p>

        <p>
            La classe ha i seguenti metodi,
            <ul>
                <li>Get</li>
                <li>Post</li>
                <li>TypeIs</li>
                <li>Body</li>
            </ul>
        </p>
    </section>

    <section>
        <h2>Router</h2>
        <p>
            La classe <b>Router</b> &egrave; deputata per elaborare le rotte dell'appricazione. Tutte le rotte sono salvate nel file <em>web.php</em>.
            Il file web.php si trova nella cartella: app/config/web.php. 
        </p>   

        <p>
            Le richichieste che la classe pu&ograve; gestire le seguenti richieste.
            <ul>
                <li>Get</li>
                <li>Post</li>
                <li>Delete</li>
                <li>Put</li>
            </ul>
        </p>
        <pre><code>
            #Esempio di una rotta:
            $app->router->get('/', [Controller::class, 'nome_metodo']);
        </code></pre>
        <p>Per le richieste non standard HTTP: PUT, DELETE &egrave; necessario aggiungere al form che gestisce la richiesta la seguente richiesta:</p>
        <pre><code>
            #Form di Esempio
            &lt;form method="post" action=""&gt;
            &lt;input type="hidden" name="__method" value="DELETE"&gt;
            &lt;/form&gt;
        </code></pre>
    </section>

    <section>
        <h2>Response</h2>
        <p>La classe <b>Response</b> si occupu di mostrare le risposte all'utente.</p>
        <ul>
            <li>Redirect</li>
            <li>Esci</li>
        </ul>
    </section>

    <footer>
        &lt;3 ossicino vr 0.2 - &copy; 2023 Mostrillo - Fatto con GruGru
    </footer>

</body>
</html>