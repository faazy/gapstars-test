<?php

namespace App\Exports;

use App\Contracts\OutPutInterface;
use App\Exports\Contracts\ExportInterface;

class CsvOutput implements ExportInterface
{
    const VAT = 21;

    /**
     * @param $data
     * @return bool
     */
    public function output(\Generator $data)
    {
        $header = ["Brand", "Total Turnover - Vat Included (21%)", "Total Turnover - Vat Excluded"];
        $body = [];

        foreach ($data as $key => $item) {
            //Append Dates to Header
            if (isset($item->date) && !in_array($item->date, $header))
                $header[] = $item->date;

            //If brand id is null skip the row
            if (is_null($item->brand_id))
                throw new \UnexpectedValueException("Invalid Brand id");

            if (isset($body[$item->brand_id])) {
                $body[$item->brand_id][] = $item->turnover;
            } else {
                //@Todo Code refactoring should according solid Open/close principles - VAT
                $vat_excluded = ($item->brand_turnover ?: 0) * (1 - self::VAT / 100); //21% Vat excluded
                $body[$item->brand_id] = [$item->name, $item->brand_turnover, $vat_excluded, $item->turnover];
            }
        }

        return $this->writeToOutput($header, $body);
    }

    /**
     * Stream to output
     *
     * @param $header
     * @param $body
     * @return bool
     */
    protected function writeToOutput($header, $body)
    {
        $fp = fopen('php://output', 'a');
        //CSV Header setters
        fputcsv($fp, $header);

        //Write Rows for Brand wise
        foreach ($body as $row)
            fputcsv($fp, $row);

        //File Download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="brand_turnover.csv"');

        return fclose($fp);
    }

    /**
     *
     */
    public function setHeader()
    {
        $items = func_get_args();
    }
}
