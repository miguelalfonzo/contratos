<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;



class ExportGeneral implements FromArray ,ShouldAutoSize
{
	protected $invoices;
	
    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        return $this->invoices;
    }


    public function styles(Worksheet $sheet)
    {
        return [
            
            1    => ['font' => ['bold' => true]],

           
        ];
    }



}

