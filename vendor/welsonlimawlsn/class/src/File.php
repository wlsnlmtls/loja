<?php

namespace Welsonlimawlsn;

class File {

	private $file;
	private $dir;
    private $name;
    private $extension;

    public function __construct($file, $name = null, $dir = "files", $extension = null)
    {
		$this->file = $_FILES[$file];
		$this->dir = $dir;
        $this->name = $name;
        $this->extension = $extension;
        File::createDir($this->dir);
    }
    
    public function converterAndUpload()
    {
        if($this->extension === null)
        {
            throw new \Exception("A extensão não foi escolhida. Passe no construtor da classe File");
        }
        else
        {
            $extension = explode('.', $this->file["name"]);
            $extension = end($extension);
            switch($extension)
            {
                case "jpg":
                case "jpeg":
                    $image = imagecreatefromjpeg($this->file["tmp_name"]);
                    break;
                case "gif":
                    $image = imagecreatefromgif($this->file["tmp_name"]);
                    break;
                case "png":
                    $image = imagecreatefrompng($this->file["tmp_name"]);
                    break;
                default:
                    imagedestroy($image);
                    throw new \Exception("Imagens com essa extenção ainda não é suportada pelo sistema.");
            }
            $filename = $this->dir.DIRECTORY_SEPARATOR.$this->name.".".$this->extension;
            switch($this->extension)
            {
                case "jpg":
                case "jpeg":
                    imagejpeg($image, $filename);
                    break;
                case "gif":
                    imagegif($image, $filename);
                    break;
                case "png":
                    imagepng($image, $filename);
                    break;
                default:
                    imagedestroy($image);
                    throw new \Exception("Formato de imagem ainda não é suportado");
            }
            imagedestroy($image);
        }
    }

    public function getUrl():string
    {
		return $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].$this->dir."/".$this->name;
	}

    public static function createDir($dir)
    {
        if(!is_dir($dir))
        {
			mkdir($dir);
		}
	}
}