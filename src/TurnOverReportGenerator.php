<?php

namespace App;

use App\Contracts\OutPutInterface;
use App\core\Validation;
use App\Exports\Contracts\ExportInterface;
use App\Repositories\TurnOverResults;

class TurnOverReportGenerator
{

    /**
     * @var TurnOverResults
     */
    protected $data;

    /**
     * @var OutPutInterface
     */
    protected $formatter;

    /**
     * TurnOverReportGenerator constructor.
     * @param TurnOverResults $turnOverResults
     * @param ExportInterface $export
     */
    public function __construct(TurnOverResults $turnOverResults, ExportInterface $export)
    {
        $this->data = $turnOverResults;
        $this->formatter = $export;
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return
     * @throws \Exception
     */
    public function getTurnOverReport(string $startDate, string $endDate)
    {
        if (!Validation::isDate($startDate) || !Validation::isDate($endDate)) {
            throw new \InvalidArgumentException("Invalid date given");
        }

        return $this->formatter->output(
            $this->data->getPeriodWise($startDate, $endDate)
        );
    }


}
