<?php

namespace App\Services;

use App\database\DB;

class PageViewService
{
    private DB $db;
    public function __construct(DB $db = null)
    {
        $this->db = $db ?: new DB();
    }
    public function getUniqueVisitors(array $queryParams): array
    {
        $sql = 'SELECT client_id, pathname, COUNT(DISTINCT user_uuid) AS unique_users FROM page_views WHERE 1 %s GROUP BY client_id, pathname';
        $filter = '';
        $filtersArr = [];

        if (!empty($queryParams['client_id'])) {
            $filter .= ' AND client_id = :client_id';
            $filtersArr['client_id'] = $queryParams['client_id'];
        }

        if (!empty($queryParams['start_date'])) {
            $filter .= ' AND created_at >= :start_date';
            $filtersArr['start_date'] = $queryParams['start_date'];
        }

        if (!empty($queryParams['end_date'])) {
            $filter .= ' AND created_at <= :end_date';
            $filtersArr['end_date'] = $queryParams['end_date'];
        }

        $result = $this->db->query(sprintf($sql,$filter));

        foreach ($filtersArr as $field => $value) {
            $result->bind($field, $value);
        }

        return $result->resultSet() ?: [];
    }
}