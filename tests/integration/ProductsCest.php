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

    /**
     * @test
     * @param IntegrationTester $I
     */
    public function it_finds_category_by_slug(IntegrationTester $I)
    {
        $expectedData = [
            'slug'        => 'expected-slug',
            'name'        => 'expected-name',
            'price'       => 'expected-price',
            'description' => 'expected-description',
        ];

        $expectedProductId = $I->haveInDatabase('products', $expectedData);

        $productsDbService = IoC::resolve(ProductsDbService::class);
        $actualProduct = $productsDbService->findBySlug('expected-slug');

        $I->assertEquals($expectedProductId, $actualProduct['id']);

        $I->assertEquals($expectedData,
            array_intersect_key($actualProduct, array_flip(['slug', 'name', 'price', 'description'])));
    }
}
