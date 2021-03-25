<?php

namespace App\Repositories;

use App\Core\Database;

class TurnOverResults
{

    /**
     * @var Database
     */
    private $db;

    /**
     * TurnOverResults constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    /**
     * @return string
     */
    public function getBrandWise()
    {
        return $this->db->query("SELECT 
                                            brand_id, 
                                            brands.name, 
                                            SUM(turnover) as turnover 
                                        FROM brands 
                                            INNER JOIN gmv on brands.id = gmv.brand_id 
                                        GROUP BY brand_id");
    }

    /**
     * Get Data of Given Period dates
     *
     * @param $start_date
     * @param $end_date
     * @return array|string
     */
    public function getPeriodWise(string $start_date, string $end_date)
    {
        return $this->db->query("SELECT brand_id, 
                                            brands.name, 
                                            DATE(date) as date, 
                                            SUM(turnover) as turnover,
                                            (SELECT SUM(turnover) FROM gmv as gmv2 WHERE gmv2.brand_id = brands.id) as brand_turnover
                                       FROM 
                                            brands INNER JOIN gmv on brands.id = gmv.brand_id
                                       WHERE 
                                             DATE(date) between :start and :end
                                       GROUP BY date, brand_id
                                       ORDER BY brand_id",
            [':start' => $start_date, ':end' => $end_date]
        );
    }

}
