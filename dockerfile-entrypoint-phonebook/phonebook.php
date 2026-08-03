#!/usr/bin/env php
<?php

$stdin = fopen('php://stdin', 'r');

while(true) {
    echo "Enter Phone|exit: ";

    $in = fgets($stdin);

    $in = trim($in);

    if ('exit' === $in) {
        echo "🆗 EXIT \n";

        break;
    }

    sleep(1);

    file_put_contents(
        getenv('DATA_STORE'), 
        $in . PHP_EOL, 
        FILE_APPEND
    );

    echo "saved {$in}" . PHP_EOL;
}

fclose($stdin);