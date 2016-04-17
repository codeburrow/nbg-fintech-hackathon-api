<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace App\Controllers\Api\V1;

use App\DbServices\Product\ProductService;
use App\Kernel\IoC;
use App\Requests\Api\ProductsPayRequest;

/**
 * Class ProductsController.
 */
class ProductsController
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * ProductsController constructor.
     * @param ProductService $productDbService
     */
    public function __construct(ProductService $productDbService)
    {
        $this->productService = $productDbService;
    }

    /**
     * Pay for a product.
     */
    public function pay()
    {
        IoC::resolve(ProductsPayRequest::class)
            ->validate();
    }
}