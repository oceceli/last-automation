<?php

namespace App\Contracts;

interface ExportsContract
{
    public function exportToExcel();

    public function exportToPDF();
}