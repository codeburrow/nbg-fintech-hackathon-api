<?php


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
            'slug'  => 'expected-slug', 'name' => 'expected-name', 'description' => 'expected-description',
            'price' => 'expected-price'
        ];

        $I->dontSeeInDatabase('products', $expectedData);

        $productDbService = new ProductDbService();

        $I->assertNotSame(false, $actualProductId = $productDbService->create($expectedData));

        $actualProduct = $productDbService->findBySlug($expectedData['slug']);

        $I->seeInDatabase('products', $expectedData);

        $I->assertEquals(
            $expectedData,
            array_intersect_key($actualProduct, array_flip(['slug', 'name', 'description', 'price'])));
    }
}
