<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace App\Controllers\Api\V1;

use App\DbServices\Product\ProductService;
use App\Kernel\IoC;
use App\Requests\Api\ProductsPayRequest;
use App\Responders\Api\ApiResponder;
use App\Transformers\Transformer;

/**
 * Class ProductsController.
 */
class ProductsController
{
    use ApiResponder;

    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * ProductsController constructor.
     * @param ProductService $productDbService
     * @param Transformer    $transformer
     */
    public function __construct(ProductService $productDbService, Transformer $transformer)
    {
        $this->productService = $productDbService;
        $this->transformer = $transformer;
    }

    /**
     * Expects a $_GET key of 'product-slug'. The ProductsPayRequest will make sure this exists.
     * Pay for a product.
     */
    public function pay()
    {
        IoC::resolve(ProductsPayRequest::class)
            ->validate();

        $productSlug = $_GET['product-slug'];

        if ($this->productService->payBySlug($productSlug)) {
            $product = $this->productService->findBySlug($productSlug);

            return $this->respondWithSuccess($this->transformer->transform($product));
        }

        return $this->respondInternalServerError();
    }

    /**
     * Get all products.
     */
    public function index()
    {
        $products = $this->productService->get();

        return $this->respondWithSuccess($this->transformer->transformCollection($products));
    }

    /**
     * Expects a $_GET key of 'product-slug'. The ProductsPayRequest will make sure this exists.
     * Pay for a product.
     */
    public function reset()
    {
        IoC::resolve(ProductsPayRequest::class)
            ->validate();

        $productSlug = $_GET['product-slug'];

        if ($this->productService->resetPaymentBySlug($productSlug)) {
            $product = $this->productService->findBySlug($productSlug);

            return $this->respondWithSuccess($this->transformer->transform($product));
        }

        return $this->respondInternalServerError();
    }
}