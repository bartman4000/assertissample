Assertis Sample Application
===================================

Installation:
-------------

* Download Composer Manager to root directory as it's described on [getcomposer.org](https://getcomposer.org) 
* Install dependencies and autoloader by typing `php composer.phar install`
* If you want to run automatic tests download and install **Phpunit** as it's described on [phpunit.de](https://phpunit.de/) 


Configuration (optional):
------------------------

* Set output/input folder for csv file in **PayrollBuilder** `const OUTPUT_DIR = 'output'`; 


Testing:
------------------------
* Use **phpunit** in root dir to run tests


Run application:
------------------------
* Type `php start.php <filename.csv>`. Example: `php start.php payroll.csv`
