<?php
declare(strict_types=1);

namespace Libreria\Html;

class Table
{
    private ?array $head = null;
    private string $caption = '';
    private array $body;
    private array $foot;
    private string $table = '';
    private string $id;
    private string $class;
    public function __construct(string $id = '', string $class = '')
    {
        $this->id = $id;
        $this->class = $class;
    }

    public function caption(string $caption = ''):Table
    {
        $this->caption = $caption;
        return $this;
    }

    public function head(string|array $head): Table
    {
        if(is_string($head))
        {
            $head = str_replace(' ', '', $head);
            $this->head = explode(',',$head);
            return $this;
        }
        $this->head = $head;
        return $this;
    }

    public function body(array $body): Table
    {
        $this->body = $body;
        return $this;
    }

    private function generaTable(): void
    {
        $html = "<table>\n";

        if($this->caption != '')
        {
            $html .= "<caption>{$this->caption}</caption>\t\n";
        }

        $html .= "<thead>\n<tr>\n";

        foreach($this->head as $intestazione)
        {
            $html .= "<th>{$intestazione}</th>\n";
        }

        $html .= "</tr>\n</thead>\n";

        $html .= $this->generaBody();


        $html .= "</table>";

        $this->table = $html;
    }

    private function generaBody(): string
    {
        $body = '';
        foreach($this->body as $valore)
        {
            $body .= "<tr>";
                foreach($this->head as $intestazione)
                {
                    $body .= "<td>{$valore->$intestazione}</td>";
                }
            $body .= "</tr>";
        }
        return $body;
    }

    public function __toString(): string
    {
        $this->generaTable();
        return $this->table;
    }
}