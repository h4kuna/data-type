#!/bin/bash

DIR=`dirname $0`

cd $DIR/..
composer install
rm -rf $DIR/temp/*

$DIR/../vendor/phpunit/phpunit/phpunit -c $DIR/phpunit.xml $@
