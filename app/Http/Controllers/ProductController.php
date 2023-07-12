<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(): JsonResponse
    {
        $data = QueryBuilder::for(Product::class)
            ->defaultSort('-updated_at')
            ->allowedFilters(['id', 'name'])
            ->paginate(10);

        return successResponseJson($data, 'Successfully fetched records.');
    }
}
