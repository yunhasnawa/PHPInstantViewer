<?php

// Copyright(c) 2021 by Yoppy Yunhasnawa

require 'piv/Db.php';
require 'piv/App.php';
require 'piv/View.php';

use piv\Db;
use piv\App;

// Change these variables to meet your needs
$mysqlHost = 'localhost';
$user = 'root';
$password = '';
$dbName = 'toko_barokah';
$tableName = 'transaksi';

$db = new Db($mysqlHost, $user, $password, $dbName);
$app = new App($db, $tableName);
$app->run();

