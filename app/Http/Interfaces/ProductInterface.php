<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductInterface
{
    public function getProductsSearched(string $name): LengthAwarePaginator;

    public function getAllProducts(): LengthAwarePaginator;

    /**
     * Get articles by criterion
     */
    public function getProductsByCriterion(string $name, array $price, array $type, string $orderBy): LengthAwarePaginator;
}
