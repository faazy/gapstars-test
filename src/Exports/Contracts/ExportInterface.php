<?php

namespace App\Exports\Contracts;

interface ExportInterface
{
    public function output(\Generator $data);

}
