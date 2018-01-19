<?php

namespace Welsonlimawlsn;

use Rain\Tpl;

class PageAdmin extends Page
{
	public function __construct($options = array(), $tpl_dir = "/views/admin/")
	{
		parent::__construct($options, $tpl_dir);
	}
}