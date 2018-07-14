<?php


class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
        echo "Starting acceptance testing";
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function testApp(AcceptanceTester $I)
    {
        $I->amOnPage("/");
        $I->canSeeResponseCodeIs("200");
        $I->amOnPage("232323");
        $I->cantSeeResponseCodeIs(500);
    }
}
