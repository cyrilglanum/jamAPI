<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductInterface
{
    public function getProduct(string $name): Model;

    public function getAllProducts(): LengthAwarePaginator;

    /**
     * Get articles by criterion
     */
    public function getProductsByCriterion(string $name, array $price, array $type, string $orderBy): LengthAwarePaginator;
}
