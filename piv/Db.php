<?php
/**
 * This file is part of KMeans-Kerjasama
 *
 * Copyright (c) 2020 Yoppy Yunhasnawa
 * Email: yunhasnawa@polinema.ac.id
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace piv;

use \mysqli;

class Db
{
    private $_connection;
    private $_dbName;

    public function __construct($mysqlHost, $user, $password, $dbName)
    {
        $this->_connection = new mysqli("$mysqlHost","$user","$password","$dbName");

        $this->_dbName = $dbName;

        if ($this->_connection->connect_errno)
        {
            echo "Failed to connect to MySQL: " . $this->_connection->connect_error;
            exit();
        }
    }

    private static function prettifyHeaders(array $columns)
    {
        $pretty = array();

        foreach ($columns as $column)
        {
            $c = strtolower($column);
            $c = str_replace('_', ' ', $c);
            $c = ucwords($c);

            $pretty[] = $c;
        }

        return $pretty;
    }

    public function executeQuery($sql)
    {
        $result = $this->_connection->query($sql);

        $records = array();

        while ($fetch = $result->fetch_assoc())
        {
            $row = array();

            foreach ($fetch as $col => $val)
            {
                $row[$col] = $val;
            }

            $records[] = $row;
        }

        return $records;
    }

    public function getTableColumnNames($tableName, $prettify = false)
    {
        $sql = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA` = '{$this->_dbName}' AND `TABLE_NAME`='$tableName';";

        $result = $this->executeQuery($sql);

        $columns = array();

        foreach ($result as $row)
        {
            $columns[] = $row['COLUMN_NAME'];
        }

        if(!$prettify)
            return $columns;

        return self::prettifyHeaders($columns);
    }


}