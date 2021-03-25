<?php
require "vendor/autoload.php";

use App\Core\Database;
use App\Core\MySQLConnection;
use App\Exports\CsvOutput;
use App\Repositories\TurnOverResults;
use App\TurnOverReportGenerator;


$report = new TurnOverReportGenerator(
    new TurnOverResults(new Database(new MySQLConnection())),
    new CsvOutput()
);

return $report->getTurnOverReport('2018-05-01', '2018-05-07');
