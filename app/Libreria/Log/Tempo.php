<?php

namespace Libreria\Log;

class Tempo
{
    #https://gist.github.com/DarkStoorM/eb950d4cb8b65852f32f155183185e5d
    protected float $tempo_avvio;
    protected float $tempo_fine;
    protected bool $autoAvvio;
    public function __construct(bool $autoAvvio = false)
    {
        $this->autoAvvio = $autoAvvio;

        if($autoAvvio)
        {
            $this->avvia();
        }
    }

    public function avvia()
    {
        $this->tempo_avvio = $this->micro();
    }

    public function ferma()
    {
        $this->tempo_fine = $this->micro();
    }

    protected function micro()
    {
        list($usec,$sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    protected function tempoLeggibile(float $tempo):string
    {
        if ($tempo < 0.001) {
            return round($tempo * 1000000) . 'μs';
        } elseif ($tempo < 1) {
            return round($tempo * 1000, 2) . 'ms';
        }

        return round($tempo, 2) . 's';
    }

    public function __toString()
    {
        if(!isset($this->tempo_fine))
        {
            $this->ferma();
        }
        $tempo = $this->tempoLeggibile($this->tempo_fine - $this->tempo_avvio);
        return  "Tempo: {$tempo}";
    }
}