<?php namespace Tests\api;


use ApiTester;
use App\DbServices\Product\ProductDbService;

class ProductsCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    /**
     * @test
     * @param ApiTester $I
     */
    public function it_pays_a_product(ApiTester $I)
    {
        $data = [
            'slug'        => 'some-slug',
            'name'        => 'some-name',
            'price'       => 'some-price',
            'description' => 'some-description',
        ];
        $expectedData = $data;

        $productsDbService = new ProductDbService();
        $productsDbService->create($data);

//        var_dump($productsDbService->findBySlug('some-slug'));exit;
        $I->assertSame('0', $productsDbService->findBySlug('some-slug')['payed']);

        $I->amOnPage("/api/v1/products/pay?product-slug={$data['slug']}");

        $I->seeCurrentUrlEquals("/api/v1/products/pay?product-slug={$data['slug']}");

        $I->seeResponseContainsJson([
            'status_code' => 200,
            'data'        => $expectedData
        ]);
    }

    /**
     * @test
     * @param ApiTester $I
     */
    public function it_returns_errors_when_making_incorrect_payment_request(ApiTester $I)
    {
        $I->amOnPage("/api/v1/products/pay");

        $I->seeResponseContainsJson([
            'error' => [
                'message'     => "The parameter 'product-slug' is missing.",
                'status_code' => 422
            ]
        ]);

        $I->amOnPage('/api/v1/products/pay?product-slug=non-exi');

        $I->seeResponseContainsJson([
            'error' => [
                'message'     => "The given product slug does not exist.",
                'status_code' => 422
            ]
        ]);
    }
}
