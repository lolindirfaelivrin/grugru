<?php
declare(strict_types=1);
namespace Libreria;

class CSRF
{
    protected string $gettone;
    protected string $gettone_nome = '_gettone';
    protected int $durata = 60*60*24;
    protected string $chiave = 'grugru_gettone';
    public function genera(int $forza = 32)
    {
        $this->gettone = bin2hex(random_bytes($forza));

        $_SESSION[$this->chiave] = [
            'gettone' => $this->gettone,
            'durata' => $this->durata
        ];

        return $this;
    }

    public function nome(string $nome)
    {
        $this->gettone_nome = $nome ?? '_gettone';

        return $this;
    }

    public function verifica(string $gettone): bool
    {
       $tempo = time(); 

       #$gettone = filter_input(INPUT_POST, $_POST['_gettone'], FILTER_SANITIZE_STRING);
       #return hash_equals($_SESSION[$this->chiave]['gettone'], $_POST['_gettone']);
       return hash_equals($_SESSION[$this->chiave]['gettone'], $gettone);
    }

    public function html()
    {
        return "<input type='hidden' name='{$this->gettone_nome}' value='{$this->gettone}'>";
    }
    
}
