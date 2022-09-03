#!/bin/bash

DFILE="/tmp/MonoInverter/$1"

if [ -f "$DFILE" ]; then
        if [[ $(find "$DFILE" -mmin +29 -print) ]]; then
                echo ""
        else
                cat $DFILE
        fi
else
        echo "Nonexistent parameter"
fi
