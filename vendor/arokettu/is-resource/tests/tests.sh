#!/usr/bin/env bash

cd "$(dirname "$0")"

php tests.php && php --no-php-ini test_unloaded.php

exit $?
