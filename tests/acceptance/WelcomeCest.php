<?php


class WelcomeCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /** @test */
    public function it_views_marketing_page(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->seeCurrentUrlEquals('/');
        $I->see('Show Marketing Page.');
    }
}
