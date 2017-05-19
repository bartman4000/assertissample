<?php
/**
 * Created by PhpStorm.
 * User: Bartek
 * Date: 2017-05-14
 * Time: 16:30
 */

define('ROOT_DIR', realpath(dirname(__FILE__) . '/'));

// setup required files
require_once 'vendor/autoload.php';


$Sales = new PayrollBuilder(new MonthSalary());

if(!isset($argv[1]))
{
    exit("Give csv filename.");
}

$Sales->preparePayroll($argv[1]);