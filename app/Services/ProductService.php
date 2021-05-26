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
     * 获取热销商品
     * @author zhenhong~
     */
    public function getProductHotList($limit = 10)
    {
       return $this->product::query()->where('on_sale', 1)
           ->orderBy('sold_count', 'desc')
           ->select(['id', 'title', 'price', 'sold_count', 'image'])
           ->paginate($limit);
    }

    /**
     * @param $id
     * @return Product|Product[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * 通过ID获取商品
     * @author zhenhong~
     */
    public function findProductById($id)
    {
        return $this->product::query()->with('productTemplate')->find($id);
    }

}
