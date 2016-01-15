<?php

namespace Wk\GoogleSpreadsheetBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Wk\GoogleSpreadsheetBundle\Services\SpreadsheetService;

class SpreadsheetServiceTest extends WebTestCase
{
    public function testConstructorWithInvalidAccessData()
    {
        new SpreadsheetService(null);
    }
}