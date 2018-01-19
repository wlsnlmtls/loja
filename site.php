<?php

use \Welsonlimawlsn\Page;
use \Welsonlimawlsn\Model\Category;
use \Welsonlimawlsn\Model\Product;
use \Welsonlimawlsn\Model\Cart;

$app->get("/", function()
{
	$products = Product::listAll();
	$page = new Page();
	$page->setTpl("index", array(
		"products"=>Product::checkList($products)
	));
});

$app->get("/categories/:idcategory", function($idcategory)
{
	$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
	$category = new Category();
	$category->get((int)$idcategory);
	$pagination = $category->getProductsPage($page);
	$pages = [];
	for($i = 1; $i <= $pagination["pages"]; $i++)
	{
		array_push($pages, [
			"link"=>"/categories/".$category->getidcategory()."?page=".$i,
			"page"=>$i
		]);
	}
	$page = new Page();
	$page->setTpl("category", array(
		"category"=>$category->getValues(), 
		"products"=>$pagination["data"],
		"pages"=>$pages
	));
});

$app->get("/products/:desurl", function($desurl)
{
	$product = new Product();
	$product->getByUrl($desurl);
	$page = new Page();
	$page->setTpl("product-detail", array(
		"product"=>$product->getValues(),
		"categories"=>$product->getCategories()
	));
});

$app->get("/cart", function()
{
	$cart = Cart::getFromSession();
	$page = new Page();
	$page->setTpl("cart");
});