<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentazione - Validazione</title>
    <link rel="stylesheet" href="./css/ossicino.min-0.2.css">
    <link rel="stylesheet" href="./css/griglia.css">
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
    <div class="colonne">
        <aside>
            <h4>Generale</h4>
            <ul data-accento="false">
                <li>Descrizione</li>
                <li>Uso</li>
                <li>Nuova Regola</li>
            </ul>
            <h4>Metodi</h4>
            <ul data-accento="false">
                <li><a href="#capitolo-minimo">Minimo</a></li>
                <li><a href="#capitolo-massimo">Massimo</a></li>
                <li><a href="#capitolo-email">Email</a></li>
                <li><a href="#capitolo-url">Url</a></li>
                <li><a href="#capitolo-richiesto">Richiesto</a></li>
            </ul>

        </aside>
        <main>

            <section>
                <h2>Validazione</h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eveniet, maiores corporis voluptas tempora
                    dolore magnam dolor totam commodi necessitatibus deleniti, nobis culpa nam ducimus adipisci nostrum
                    molestiae aperiam incidunt aspernatur.</p>
            </section>

            <section>
                <h2>Come aggiungere una nuova regola</h2>
                <p>Per creare una nuova regola è necessario creare un nuovo file nella cartella Validazione ustilizzando
                    il namespace la classe deve iplementare l'interfaccia </p>
            </section>

            <section>
                <h2 id="capitolo-minimo">Minore</h2>
                <p>Restiruisce un valore <strong>bool</strong> se il numero o la stringa è minore del valore di
                    confronto</p>
                <code><pre>
                    $validazione = new ValidazioneMinimo(12);
                    $validazione->valida(10); //true
                </pre></code>
            </section>

            <section>
                <h2 id="capitolo-massimo">Maggiore</h2>
                <p>Restiruisce un valore <strong>bool</strong> se il numero o la stringa è maggiore del valore di
                    confronto</p>
                <code><pre>
                    $validazione = new ValidazioneMassimo(12);
                    $validazione->valida(10); //false
                </pre></code>
            </section>

            <section>
                <h2 id="capitolo-email">Email</h2>
                <p>Restiruisce un valore <strong>bool</strong> se il numero o la stringa è maggiore del valore di
                    confronto</p>
                <code><pre>
                    $validazione = new ValidazioneMassimo(12);
                    $validazione->valida(10); //false
                </pre></code>
            </section>

            <section>
                <h2 id="capitolo-url">Url</h2>
                <p>Restiruisce un valore <strong>bool</strong> se il numero o la stringa è maggiore del valore di
                    confronto</p>
                <code><pre>
                    $validazione = new ValidazioneMassimo(12);
                    $validazione->valida(10); //false
                </pre></code>
            </section>

            <section>
                <h2 id="capitolo-richiesto">Richiesto</h2>
                <p>Restiruisce un valore <strong>bool</strong> se il numero o la stringa è maggiore del valore di
                    confronto</p>
                <code><pre>
                    $validazione = new ValidazioneMassimo(12);
                    $validazione->valida(10); //false
                </pre></code>
            </section>

        </main>
    </div>


    <footer>
        &lt;3 ossicino vr 0.2 - &copy; 2023 Mostrillo - Fatto con GruGru
    </footer>

</body>
</html>