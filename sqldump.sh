#!/bin/bash

DBNAME="lovelace_bookmarks"

if mysqldump -u root -B $DBNAME > $DBNAME.sql
then
  echo "Export file $DBNAME.sql created"
else
  echo 'failed'
fi
