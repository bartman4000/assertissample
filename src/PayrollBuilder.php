<?php

const OUTPUT_DIR = 'output';

class PayrollBuilder
{
    /**
     * @var PayrollRowInterface
     */
    private $MonthRow;

    /**
     * PayrollBuilder constructor.
     * @param PayrollRowInterface $MonthRow
     */
    public function __construct(PayrollRowInterface $MonthRow)
    {
        $this->MonthRow = $MonthRow;
    }

    public function preparePayroll(string $filename) : void
    {
        if(substr("$filename", -4) != '.csv')
        {
            $filename.='.csv';
        }
        if(!is_dir(OUTPUT_DIR))
        {
            mkdir(OUTPUT_DIR);
        }
        $filename = OUTPUT_DIR.'/'.$filename;

        $existingPayroll = $this->readOldPayroll($filename);
        $remainingMonths = $this->getRemainingMonths(new DateTime('now'));
        $payroll = $this->makeNewPayroll($remainingMonths,$existingPayroll);
        $outputFile = $this->savePayrollToFile($payroll,$filename);
        echo "Payroll was saved to {$outputFile}";
    }

    public function isFileReadable(string $file)
    {
        return file_exists($file) && ($handle = fopen($file, "r")) !== FALSE;
    }

    public function isFileWriteable(string $file)
    {
        return $handle = fopen($file, "w") !== FALSE;
    }

    public function getRemainingMonths(DateTime $date) : array
    {
        $currentMonth = date('m', $date->getTimestamp());
        $remainingMonths = array();
        for($i = $currentMonth; $i <= 12; $i++)
        {
            $remainingMonths[] = date('F', mktime(0, 0, 0, $i, 1));
        }
        return $remainingMonths;
    }

    public function savePayrollToFile(array $payroll, string $filename) : string
    {
        if(!$this->isFileWriteable($filename))
        {
            $filename = tempnam ( OUTPUT_DIR , 'payroll');
        }
        $fp = fopen($filename, 'w');

        fputcsv($fp, $this->MonthRow::getCVSHeaders());
        foreach ($payroll as $salaryRow)
        {
            fputcsv($fp, $salaryRow);
        }

        fclose($fp);
        return $filename;
    }

    protected function readOldPayroll(string $filename) : array
    {
        $existingPayroll = array();
        if ($this->isFileReadable($filename))
        {
            $rows = array_map('str_getcsv', file($filename));
            array_shift($rows); //skip header row
            foreach($rows as $row)
            {
                if(!empty($row))
                {
                    $existingPayroll[$row[0]] = $row;
                }
            }
        }
        return $existingPayroll;
    }

    public function makeNewPayroll(array $remainingMonths, array $existingPayroll = array()) : array
    {
        $payroll = array();
        foreach($remainingMonths as $month)
        {
            if($this->isMonthProcessed($month,$existingPayroll))
            {
                $payroll[$month] = $existingPayroll[$month];
            }
            else
            {
                $payroll[$month] = $this->MonthRow->prepareMonthRow($month);
            }
        };
        return $payroll;
    }

    public function isMonthProcessed(string $month, array $existingPayroll) : bool
    {
        return isset($existingPayroll[$month]) && is_array($existingPayroll[$month]);
    }

}