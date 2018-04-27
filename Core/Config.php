<?php

namespace PhpBlog\Core;

class Config
{
    private $config;

    public function __construct()
    {
        $config = __DIR__ . '../config/config.php';
        $this->config = $config;
    }

    /**
     * @param string $key
     * @return null
     */
    public static function get(string $key)
    {
        if ( isset(self::$config[$key]) )
        {
            return self::$config[$key];
        }
        else
        {
            return null;
        }
    }
}