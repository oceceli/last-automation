<?php

namespace App\Contracts;

interface Exports
{
    public function exportToExcel();

    public function exportToPDF();
}