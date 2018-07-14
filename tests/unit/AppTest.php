<?php

require __DIR__ . '/../../config/local.config.php';

class AppTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testDBConnection()
    {
        $db = \Core\Service\Database::getDB();

        $this->assertNotFalse($db);
    }

    public function testGEOServie()
    {
        $service = new \Core\Service\Geo();

        $result = $service->getCountryCodeByIp("8.8.8.8");

        $this->assertEquals(2, strlen($result));
    }
}