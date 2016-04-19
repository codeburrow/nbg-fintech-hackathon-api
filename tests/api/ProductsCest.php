<?php namespace Tests\api;


use ApiTester;
use App\DbServices\Product\ProductDbService;
use Database\migrations\DatabaseMigration;

class ProductsCest
{
    public function _before(ApiTester $I)
    {
        DatabaseMigration::provision();
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
        $expectedData['payed'] = true;

        $productsDbService = new ProductDbService();
        $productsDbService->create($data);

        $I->assertSame('0', $productsDbService->findBySlug('some-slug')['payed']);

        $I->amOnPage("/api/v1/products/payment/request?product-slug={$data['slug']}");

        $I->seeCurrentUrlEquals("/api/v1/products/payment/request?product-slug={$data['slug']}");

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
        $I->amOnPage("/api/v1/products/payment/request");

        $I->seeResponseContainsJson([
            'error' => [
                'message'     => "The parameter 'product-slug' is missing.",
                'status_code' => 422
            ]
        ]);

        $I->amOnPage('/api/v1/products/payment/request?product-slug=non-exi');

        $I->seeResponseContainsJson([
            'error' => [
                'message'     => "The given product slug does not exist.",
                'status_code' => 422
            ]
        ]);
    }

    /**
     * @test
     * @param ApiTester $I
     */
    public function it_reads_products_index(ApiTester $I)
    {
        $expectedData = [
            [
                'slug'        => 'some-slug',
                'name'        => 'some-name',
                'price'       => 'some-price',
                'description' => 'some-description',
            ],
            [
                'slug'        => 'some-slug-2',
                'name'        => 'some-name-2',
                'price'       => 'some-price-2',
                'description' => 'some-description-2',
            ]
        ];
        $productsDbService = new ProductDbService();

        $productsDbService->create($expectedData[0]);
        $productsDbService->create($expectedData[1]);

        $I->amOnPage('/api/v1/products');

        $I->seeCurrentUrlEquals('/api/v1/products');

        $I->seeResponseContainsJson([
            'status_code' => 200,
            'data'        => $expectedData
        ]);
    }

    /**
     * @test
     * @param ApiTester $I
     */
    public function it_resets_product_payment(ApiTester $I)
    {
        $data = [
            'slug'        => 'some-slug',
            'name'        => 'some-name',
            'price'       => 'some-price',
            'description' => 'some-description',
            'payed'       => 1,
        ];
        $expectedData = $data;
        $expectedData['payed'] = false;
        $productsDbService = new ProductDbService();
        $productsDbService->create($data);

        $I->assertSame('1', $productsDbService->findBySlug('some-slug')['payed']);

        $I->amOnPage("/api/v1/products/payment/reset?product-slug={$data['slug']}");
        $I->seeCurrentUrlEquals("/api/v1/products/payment/reset?product-slug={$data['slug']}");

        $I->seeResponseContainsJson([
            'status_code' => 200,
            'data'        => $expectedData
        ]);
    }

    /**
     * @test
     * @param ApiTester $I
     */
    public function it_reads_product_status(ApiTester $I)
    {
        $data = [
            'slug'        => 'some-slug',
            'name'        => 'some-name',
            'price'       => 'some-price',
            'description' => 'some-description',
        ];
        $expectedData = $data;
        $expectedData['payed'] = false;

        $productsDbService = new ProductDbService();

        $I->assertNotSame(false, $productsDbService->create($expectedData));

        $I->amOnPage('/api/v1/products/payment/status?product-slug=some-slug');

        $I->seeCurrentUrlEquals('/api/v1/products/payment/status?product-slug=some-slug');

        $I->seeResponseContainsJson([
            'status_code' => 200,
            'data'        => $expectedData
        ]);
    }
}
