#!/usr/bin/env php
<?php

$stdin = fopen('php://stdin', 'r');

while(true) {
    $in = fgets($stdin);

    $in = trim($in);

    if ($in === 'exit') {
        echo "👋 Bye \n";

        break;
    }

    sleep(1);

    echo "🗿 The Gratest Man Ever: {$in} \n";
}

fclose($stdin);