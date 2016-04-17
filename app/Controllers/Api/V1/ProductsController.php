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
     * @api            {get} api/v1/products Get all products
     * @apiPermission  none
     * @apiVersion     1.0.0
     * @apiName        GetProducts
     * @apiGroup       Products
     * @apiDescription Fetch list, with products.
     * @apiExample {curl} Example usage:
     *
     * curl -i -H "Accept: application/json" -H "Content-Type: application/json" -X GET "http://zapit-web.herokuapp.com/api/v1/products"
     *
     * @apiSuccess {String} status_code Request status.
     * @apiSuccess {String[]} data The array with products.
     * @apiSuccess {String} slug The unique identification for each product.
     * @apiSuccess {String} name The unique name for each product.
     * @apiSuccess {String} price Price of the product.
     * @apiSuccess {String} description Description of the product.
     * @apiSuccess {String} payed Payment status for the product.
     *
     * @apiSuccessExample {json} Success-Response:
     *      HTTP/1.1 200 OK
     *      {
     *          "status_code" : 200
     *          "data" :  [
     *              {
     *                  "slug": "iot",
     *                  "name": "IoT",
     *                  "price": "100",
     *                  "description": "Description of an IoT",
     *                  "payed": "0",
     *              },
     *              {
     *                  "slug": "cards-against-humanity",
     *                  "name": "Cards Against Humanity",
     *                  "price": "25",
     *                  "description": "Cards Against Humanity is a party game for horrible people. Unlike most of the party games you've played before, Cards Against Humanity is as despicable and awkward as you and your friends. ",
     *                  "payed": "0",
     *              },
     *          ],
     *      }
     */

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