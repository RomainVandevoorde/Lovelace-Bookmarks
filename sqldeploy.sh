#!/bin/bash

DBNAME="lovelace_bookmarks"

checkcmd() {
    if [ ! -x "$(command -v $1)" ]; then
        echo "Command $1 unavailable, check your mysql configuration"
        exit
    fi
}

checkcmd mysql
checkcmd mysqlshow

VERB="create"

if [ "$(mysqlshow -u root | grep -o $DBNAME)" == $DBNAME ]; then
  VERB="update"
fi


read -p "Your MySQL username: " USER
read -p "Your MySQL password: " PASSWD

if mysql -u $USER --password=$PASSWD < $DBNAME.sql 2> /dev/null
then
  phrase="Local database $VERB"
  phrase+="d"
  echo $phrase
else
  echo Failed to $VERB local database
fi
