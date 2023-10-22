<h1>Contatti</h1>
<form action="" method="post">
    <label for="email">
        la tua email
    </label>
    <input type="email" name="email" id="email">
    <label for="messaggio">
        il tuo messaggio
    </label>
    <textarea name="messaggio" id="messaggio"></textarea>
    <?php echo $codice; ?>
    <input type="hidden" name="__method" value="">
    <input type="submit" value="Invia">
</form>