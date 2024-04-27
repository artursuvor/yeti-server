<?php

namespace App\Repository;

use Doctrine\DBAL\DriverManager;

class AbstractRepository
{
  protected $connection;

  protected $connectionParams = [];

  public function __construct() {
      $connectionParams = [
        'dbname' => 'yeti',
        'user' => 'my_user',
        'password' => 'password',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ];

    $this->connection = DriverManager::getConnection($connectionParams);
  }
}