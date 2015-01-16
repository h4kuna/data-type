#!/bin/bash

TESTS_PATH=`dirname $0`

$TESTS_PATH/../vendor/phpunit/phpunit/phpunit -c $TESTS_PATH/phpunit.xml $@
