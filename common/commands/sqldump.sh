#!/bin/bash

subdir=`dirname $0`
yiic="$subdir/../yiic"
params=`$yiic util mysqlParams`

mysqldump $@ $params > sevas_`date +%Y-%M-%d`.sql
