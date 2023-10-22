<?php

namespace Core\Controller;

use Core\Exception\VistaNonTrovata;
use Core\GruGru;


class Controller
{
    private string $estensione = '.php';
    public function view($views, $data = [])
    {
        try {

            if (!file_exists(GruGru::$ROOTDIR . '/views/' . $views . $this->estensione))
            {
                throw new VistaNonTrovata();
            }

        } catch (VistaNonTrovata $errore) {
            
            if(env('APP_DEBUG') === 'false')
            {
                echo $this->generaVista('Errori/404');
            }

            $data = ['e' => $errore];
            return $this->generaVista('Errori/Errori', $data);
        }

        return $this->generaVista($views, $data);

    }

    public function setEstensione(string $estensione)
    {
        $this->estensione = $estensione;
        return $this;
    }

    private function generaVista($views, $data = [])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        require_once GruGru::$ROOTDIR . '/views/' . $views . $this->estensione;
        return ob_get_clean();
    }
}