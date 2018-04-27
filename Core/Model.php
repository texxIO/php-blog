<?php

namespace PhpBlog;

use PhpBlog\Core\DatabaseConnection;

class Model
{
    private $table;
    private $db;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance();
    }

    public function getAll()
    {

    }
}