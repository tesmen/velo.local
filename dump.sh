#!/bin/sh
s=`date +%Y-%m-%d`

mysqldump -u user -ppassword velomarket > "dumps/$s"