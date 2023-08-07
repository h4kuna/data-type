<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Europe/Prague');

Tracy\Debugger::enable(false);
Tester\Environment::setup();
