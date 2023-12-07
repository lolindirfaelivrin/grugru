<?php

namespace Core\Controller;

use Core\Exception\VistaNonTrovata;
use Core\GruGru;
use Core\Http\enum\HttpstatusCode;


class Controller
{
    private string $estensione = '.php';
    public function view($views, $data = [])
    {
        $views = $this->generaPercorsoVista($views);

        try {

            if (!file_exists(GruGru::$ROOTDIR . '/views/' . $views . $this->estensione))
            {
                throw new VistaNonTrovata();
            }

        } catch (VistaNonTrovata $errore) {

            if(env('APP_DEBUG') === 'false')
            {
                $codice = HttpstatusCode::from($errore->getCode());
                GruGru::$APP->response->setHttpCode($codice);

                $data = ['codice' => $errore->getCode(), 'messaggio' => $errore->getMessage()];
                return $this->generaVista('Errori/PaginaErrore', $data);
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

    private function generaPercorsoVista(string $vista):string
    {
        $percorso = explode('.', $vista);

        if(count($percorso) === 1)
        {
            return $vista;
        }

        return implode(DIRECTORY_SEPARATOR, $percorso);
    }

}