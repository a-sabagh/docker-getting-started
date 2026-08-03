#!/bin/sh

set -e 

touch ${DATA_STORE}

exec "$@"