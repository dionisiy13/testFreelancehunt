<?php


class AppCest
{
    public function _before(ApiTester $I)
    {
        echo "Starting API testing";
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function users(ApiTester $I)
    {
        $I->sendGET("/get-all");
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
    }

    public function countries(ApiTester $I)
    {
        $I->sendGET("/get-countries");
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
    }


    public function usersFilter(ApiTester $I)
    {
        $I->sendGET("/get-users-filtered",['is_active'=>2, 'country'=>500]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();

        $I->sendGET("/get-users-filtered");
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();

        $I->sendGET("/get-users-filtered",['is_active'=>0, 'country'=>"*swe"]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();

        $I->sendGET("/get-users-filtered",['country'=>"1"]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
    }
}
