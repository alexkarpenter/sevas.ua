#!/bin/bash
# sql commands for current DB

subdir=`dirname $0`
yiic="$subdir/../yiic"
params=`$yiic util mysqlParams`

mysql $@ $params < /dev/stdin
