<?php

interface PayrollRowInterface
{
    public function prepareMonthRow(string $month);
    public static function getCVSHeaders();
}