<?php

class MonthSalary implements PayrollRowInterface
{
    public function prepareMonthRow(string $month) : array
    {
        $monthDate = new DateTime($month);
        return array(
            $month,
            $this->calculateBaseSalaryDay($monthDate)->format('Y-m-d'),
            $this->calculateBonusSalaryDay($monthDate)->format('Y-m-d'));
    }

    public function calculateBaseSalaryDay(DateTime $date) : DateTime
    {
        $paymentDay = new DateTime($date->format('Y-m-t'));
        $dayOfWeek = $paymentDay->format('l');
        if($dayOfWeek == 'Saturday')
        {
            $paymentDay->modify('-1 day');
        }
        elseif($dayOfWeek == 'Sunday')
        {
            $paymentDay->modify('-2 day');
        }
        return $paymentDay;
    }

    public function calculateBonusSalaryDay(DateTime $date) : DateTime
    {
        $paymentDay = new DateTime($date->format('Y-m-15'));
        $dayOfWeek = $paymentDay->format('l');
        if($dayOfWeek == 'Saturday')
        {
            $paymentDay->modify('+4 day');
        }
        elseif($dayOfWeek == 'Sunday')
        {
            $paymentDay->modify('+3 day');
        }
        return $paymentDay;
    }

    static public function getCVSHeaders() : array
    {
        return array('month','base salary date', 'bonus salary date');
    }
}