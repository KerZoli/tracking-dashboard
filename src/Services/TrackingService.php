<?php

namespace App\Services;

use App\database\DB;
use PDOException;

class TrackingService
{
    private DB $db;
    public function __construct(DB $db = null)
    {
        $this->db = $db ?: new DB();
    }

    public function checkIfClientExists(string $clientId): bool
    {
        $result = $this->db->query('SELECT COUNT(*) as count FROM clients WHERE id = :id')
            ->bind('id', $clientId)
            ->single();

        return $result['count'] === 1;
    }

    public function createPageView(string $clientId, string $visitorId, string $pathName): void
    {
        try {
            $this->db->query('INSERT INTO page_views (client_id, user_uuid, pathname, created_at) VALUES (:clientId, :userId, :path, :created_at)')
                ->bind('clientId', $clientId)
                ->bind('userId', $visitorId)
                ->bind('path', $pathName)
                ->bind('created_at', date('Y-m-d H:i:s'))
                ->execute();
        } catch (PDOException $e) {
            // TODO log would be more helpful
            echo 'Create page view failed: ' . $e->getMessage();
        }
    }
}