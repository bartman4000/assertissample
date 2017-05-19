<?php

/**
 * Created by PhpStorm.
 * User: Bartek
 * Date: 2017-05-13
 * Time: 21:43
 */

use PHPUnit\Framework\TestCase;

class PayrollBuilderTest extends TestCase
{
    /**
     * @var PayrollBuilder
     */
    private $PayrollBuilder;

    public function setUp()
    {
        $this->PayrollBuilder = new PayrollBuilder();
    }

    public function testGetRemainingMonths()
{
    $months = $this->PayrollBuilder->getRemainingMonths(new DateTime('November'));
    $this->assertContains('November', $months);
    $this->assertContains('December', $months);
    $this->assertNotContains('October', $months);
}

    public function testMakeNewPayroll()
    {
        $payroll = $this->PayrollBuilder->makeNewPayroll(array('November','December'));
        $this->assertArrayHasKey('November', $payroll);
        $this->assertArrayHasKey('December', $payroll);
        $this->assertInternalType('array', $payroll['December']);
    }
}