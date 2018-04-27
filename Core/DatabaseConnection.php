<?php
namespace PhpBlog\Core;

use PDO;
use PDOException;
use PhpBlog\Core\Config as Config;

class DatabaseConnection
{
    private static $getInstance = null;

    /**
     * DatabaseConnection constructor.
     */
    protected function __construct()
    {
        $dbdriver = Config::get('db_driver');
        $username = Config::get('db_username');
        $password = Config::get('db_password');
        $host = Config::get('db_host');
        $db = Config::get('db_name');
        $dns = "$dbdriver:dbname=$db;host=$host";

        if(!self::$getInstance) {
            try {
                self::$getInstance = new PDO($dns, $username, $password);;
            } catch (PDOException $e) {
                error_log('PDO Connection Error: ' . $e->getMessage());
                die("Error occured! <br/>");

            }
        }
        return self::$getInstance;
    }

}