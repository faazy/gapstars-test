<?php
/**
 * @Author Faazy Ahamed
 * @eMail <faaziahamed@gmail.com>
 * @Mobile +94713221220
 * Date: 25/Mar/2021
 * Time: 12:23 PM
 */

namespace App\core;


class Validation
{
    /**
     * Date Validation
     *
     * @param $date
     * @param string $format
     * @return bool
     */
    public function isDate($date, $format = 'Y-m-d'): bool
    {
        return $date == date($format, strtotime($date));
    }
}