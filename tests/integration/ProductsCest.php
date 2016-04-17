<?php


use App\Controllers\ProductsDbService;
use App\Kernel\IoC;

class ProductsCest
{
    public function _before(IntegrationTester $I)
    {
    }

    public function _after(IntegrationTester $I)
    {
    }


    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_creates_product(IntegrationTester $I)
    {
        $expectedData = [
            'slug'        => 'expected-slug',
            'name'        => 'expected-name',
            'price'       => 'expected-price',
            'description' => 'expected-description',
        ];

        $I->dontSeeInDatabase('products', $expectedData);

        $productsDbService = IoC::resolve(ProductsDbService::class);

        $I->assertNotSame(false, $actualProductId = $productsDbService->create($expectedData));

        $I->seeInDatabase('products', $expectedData);
    }
}
