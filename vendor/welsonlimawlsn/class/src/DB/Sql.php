<?php

namespace Welsonlimawlsn\DB;

class Sql
{
	const HOSTNAME = "127.0.0.1";
	const USERNAME = "root";
	const PASSWORD = "";
	const DBNAME = "db_ecommerce";

	private $conn;

	public function __construct()
	{
		$this->conn = new \PDO("mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME, Sql::USERNAME, Sql::PASSWORD);
	}

	private function setParams($statement, $parameters = array())
	{
		foreach ($parameters as $key => $value)
		{
			$this->bindParam($statement, $key, $value);
		}
	}

	private function bindParam($statement, $key, $value)
	{
		$statement->bindParam($key, $value);
	}

	public function query($rawQuery, $params = array())
	{
		$statement = $this->conn->prepare($rawQuery);
		$this->setParams($statement, $params);
		$statement->execute();
		return $statement;
	}

	public function select($rawQuery, $params = array()):array
	{
		$statement = $this->query($rawQuery, $params);
		return $statement->fetchAll(\PDO::FETCH_ASSOC);
	}
}