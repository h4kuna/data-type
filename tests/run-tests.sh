#!/bin/bash

DIR=`dirname $0`

composer install
rm -rf $DIR/temp/*

$DIR/../vendor/phpunit/phpunit/phpunit -c $DIR/phpunit.xml $@
