<?php

namespace App\Repositories;

use App\database\DB;

class ClientRepository
{
    private DB $db;
    public function __construct(DB $db = null)
    {
        $this->db = $db ?: new DB();
    }

    public function clients(): array
    {
        $results = $this->db->query('SELECT id FROM clients')
            ->resultSet();

        return $results ?: [];
    }
}