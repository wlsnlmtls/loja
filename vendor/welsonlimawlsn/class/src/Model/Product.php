<?php

namespace Welsonlimawlsn\Model;

use \Welsonlimawlsn\Model;
use \Welsonlimawlsn\File;
use \Welsonlimawlsn\DB\Sql;
use \Welsonlimawlsn\Model\Product;

class Product extends Model
{
    public static function listAll()
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");
    }

    public function save()
    {
        $sql = new Sql();
        $results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", array(
            ":idproduct"=>$this->getidproduct(),
            ":desproduct"=>$this->getdesproduct(),
            ":vlprice"=>$this->getvlprice(),
            ":vlwidth"=>$this->getvlwidth(),
            ":vlheight"=>$this->getvlheight(),
            ":vllength"=>$this->getvllength(),
            ":vlweight"=>$this->getvlweight(),
            ":desurl"=>$this->getdesurl()
        ));
        $this->setData($results[0]);
    }

    public function get($idproduct)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", array(
            ":idproduct"=>$idproduct
        ));
        $this->setData($results[0]);
    }

    public static function checkList($list)
    {
        foreach($list as &$row)
        {
            $product = new Product;
            $product->setData($row);
            $row = $product->getValues();
        }
        return $list;
    }

    public function delete()
    {
        $sql = new Sql();
        $sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct", array(
            ":idproduct"=>$this->getidproduct()
        ));
    }

    public function checkPhoto()
    {
        //C:\xampp\htdocs\store\res\site\img\products
        if(file_exists($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."res".DIRECTORY_SEPARATOR."site".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR."products".DIRECTORY_SEPARATOR.$this->getidproduct().".jpg"))
        {
            $url =  "/res/site/img/products/".$this->getidproduct().".jpg";
        }
        else
        {
            $url =  "/res/site/img/product.jpg";
        }
        $this->setdesphoto($url);
    }

    public function getValues()
    {
        $this->checkPhoto();
        $values = parent::getValues();
        return $values;
    }

    public function setPhoto($file)
    {
        $file = new File($file, $this->getidproduct(), $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."res".DIRECTORY_SEPARATOR."site".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR."products", "jpg");
        $file->converterAndUpload();
        $this->checkPhoto();
    }

    public function getByUrl($ulr)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_products WHERE desurl = :desurl", array(
            ":desurl"=>$ulr
        ));
        $this->setData($results[0]);
    }

    public function getCategories()
    {
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_categories a INNER JOIN tb_productscategories b ON a.idcategory = b.idcategory WHERE b.idproduct = :idproduct", array(
            ":idproduct"=>$this->getidproduct()
        ));
    }
}