<?php

/**
 * Created by PhpStorm.
 * User: Bartek
 * Date: 2017-05-13
 * Time: 21:43
 */

use PHPUnit\Framework\TestCase;

class MonthSalaryTest extends TestCase
{
    /**
     * @var MonthSalary
     */
    private $MonthSalary;

    public function setUp()
    {
        $this->MonthSalary = new MonthSalary();
    }

    public function testGetBaseSalaryDay()
    {
        $date = new DateTime('2017-04');
        $paymentDay = $this->MonthSalary->calculateBaseSalaryDay($date);
        $this->assertEquals('2017-04-28',$paymentDay->format('Y-m-d'));
        $this->assertNotContains($paymentDay->format('l'),array('Saturday','Sunday'));

        $date2 = new DateTime('2017-09');
        $paymentDay2 = $this->MonthSalary->calculateBaseSalaryDay($date2);
        $this->assertEquals('2017-09-29',$paymentDay2->format('Y-m-d'));
        $this->assertNotContains($paymentDay2->format('l'),array('Saturday','Sunday'));

        $date3 = new DateTime('2017-05');
        $paymentDay3 = $this->MonthSalary->calculateBaseSalaryDay($date3);
        $this->assertEquals('2017-05-31',$paymentDay3->format('Y-m-d'));
        $this->assertNotContains($paymentDay3->format('l'),array('Saturday','Sunday'));
    }

    public function testGetBonusSalaryDay()
    {
        $date = new DateTime('2017-01');
        $paymentDay = $this->MonthSalary->calculateBonusSalaryDay($date);
        $this->assertEquals('2017-01-18',$paymentDay->format('Y-m-d'));
        $this->assertEquals('Wednesday',$paymentDay->format('l'));
    }
}