<?php

namespace App\Models\Interfaces;

interface CanReserveStocks
{
    /**
     * The model must be have 'to many' relation with App\Models\ReservedStock model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reservedStocks();


    /**
     * The model also will have 'to many' relation with App\Models\StockMove model to make a move
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function stockMoves();
}