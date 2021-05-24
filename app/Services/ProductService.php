<?php
namespace App\Services;

use App\Models\Product;

class ProductService {
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductHotList($limit = 10)
    {
       return $this->product::query()->where('on_sale', 1)
           ->orderBy('sold_count', 'desc')
           ->select(['id', 'title', 'price', 'sold_count', 'image'])
           ->paginate($limit);
    }
}
