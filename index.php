<?php

// Copyright(c) 2021 by Yoppy Yunhasnawa

require 'piv/Db.php';
require 'piv/App.php';
require 'piv/View.php';

use piv\Db;
use piv\App;

// Change these variables to meet your needs
$mysqlHost = 'localhost:8889';
$user = 'root';
$password = 'root';
$dbName = 'si_kerjasama';
$tableName = 'tb_coop';

$db = new Db($mysqlHost, $user, $password, $dbName);
$app = new App($db, $tableName);
$app->run();

