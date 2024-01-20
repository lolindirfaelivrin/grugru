<?php
declare(strict_types=1);

namespace Libreria;

class Upload
{
    protected static array $errori = [];
    protected static array $informazioniUpload = [];
    protected static array $formati = [
        'immagini' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'apng', 'tif', 'tiff', 'svg', 'pjpeg', 'pjp', 'jfif', 'cur', 'ico']
    ];

    /**
     * Carica un file sul server
     *
     * @param array $file
     * @param string $path
     * @param array $configurazione
     * @return boolean|string
     */
    public static function upload(array $file, string $path, array $configurazione = []):bool|string
    {
        if(!is_dir($path))
        {
            mkdir($path, 0777, true);
        }


        if(isset($configurazione['unico']) && $configurazione['unico'] === true)
        {
            $name = strtolower(strtotime(date("Y-m-d H:i:s")) . '_' . str_replace(" ", "_", $file["name"]));
        } else {
            $name = str_replace(" ", "_", $file["name"]);
        }

        if(isset($configurazione['hash']) && $configurazione['hash'] === true)
        {
            
        }

        $temp = $file["tmp_name"];
        $size = $file["size"];
        $target_dir = $path;
        $target_file = $target_dir . basename($name);

        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        #$maximum_file_size = $config["max_file_size"] ?? 10000000;

        self::$informazioniUpload[$name] = [
			"nome" => $name,
			"dimensione" => $size,
			"tipo" => $file_type,
			#"categoria" => $file_category,
			"percorso" => $target_file,
			"parent_directory" => basename(dirname($target_file)),
			"parent_directory_path" => $target_dir
		];

        if (move_uploaded_file($temp, $target_file))
        {
            return $name;
        } else {
            self::$errori["upload"] = "Non è stato possibile caricare il file";
            return false;
        }
    }

    /**
     * Restituisce l'array degli errori
     *
     * @return array
     */
    public static function errori():array
    {
        return self::$errori;
    }

    /**
     * Restituisce le informazioni sul file caricato
     *
     * @param string|null $file
     * @return void
     */
    public static function informazioniUpload(?string $file = null)
    {
        return $file ? self::$informazioniUpload[$file] : self::$informazioniUpload;
    }
}