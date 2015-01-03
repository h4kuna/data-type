#!/bin/bash

TESTS_PATH=`dirname $0`

phpunit -c $TESTS_PATH/phpunit.xml $@