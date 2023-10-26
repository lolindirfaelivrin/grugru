<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/ossicino.min-0.2.css">
    <title>GruGru - Configurazione</title>
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
        <h1>Configurazione</h1>
        <p>Per modificare la configurazione dell'applicativo è possibile agire o sul file <strong>.env</strong> o sui
            vari file di configurazione
            presenti nella cartella <strong>app/config</strong></p>
            <h2>File Env</h2>
            <p>Allegato viene distribuito un file <strong>.env.example</strong> che contiene una configurazione tipo del framework, nello specifico
        la descrizione delle varie possibilità</p>
        <table>
            <thead>
                <tr>
                    <th>Voce</th>
                    <th>Descrizione</th>
                    <th>Valori</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>APP_NAME</td>
                    <td>Il nome dell'applocazione che potrà essere visualizzato quando necessita</td>
                    <td>Stringa</td>
                </tr>
                <tr>
                    <td>APP_ENV</td>
                    <td>Il nome dell'applocazione che potrà essere visualizzato quando necessita</td>
                    <td>Bool</td>
                </tr>
                <tr>
                    <td>APP_CHIAVE</td>
                    <td>Il nome dell'applocazione che potrà essere visualizzato quando necessita</td>
                    <td>Stringa</td>
                </tr>                
                <tr>
                    <td>APP_DEBUG</td>
                    <td>Abilita la modalità debug, se attiva mostra gli errori in modo più dettagliato</td>
                    <td>Bool</td>
                </tr>
                <tr>
                    <td>APP_LOG</td>
                    <td>Se attivo salva gli errori o altre infromazioni nel file di log <strong>app/store/log</strong></td>
                    <td>Bool</td>
                </tr>
                <tr>
                    <td>APP_UL</td>
                    <td>Indirizzo web dell'applicazione</td>
                    <td>Stringa</td>
                </tr>                
            </tbody>
        </table>
    </section>


</body>

</html>