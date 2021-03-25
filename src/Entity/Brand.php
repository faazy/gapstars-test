<?php


namespace App\Entity;

use App\Core\Database;

class Brand
{

    /**
     * @var Database
     */
    private $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }


    public function all()
    {
        return $this->db->query("SELECT id, name, description FROM brands");
    }
}
