<?php

function getSymbolLastPosition($line, $symbol)
{
    $symPos = strpos(strrev($line), $symbol);

    if (false === $symPos) {
        return false;
    }

    return strlen($line) - $symPos;
}

function cutLineBySpaces($line, $requiredLength)
{
    $line = trim($line);
    $textLength = $requiredLength - 3;
    $dots = '...';

    if (strlen($line) <= $requiredLength) {
        return $line;
    }

    $rawCut = substr($line, 0, $textLength);

    if ($rawCut[$textLength - 1] !== ' ') {
        $lastSpacePos = getSymbolLastPosition($rawCut, ' ');

        if (false === $lastSpacePos) {
            return $rawCut . $dots;
        }

        return trim(substr($rawCut, 0, $lastSpacePos )) . $dots;
    }

    return trim($rawCut) . $dots;
}

$test = 'a ass dasdasdasd           a asd';

var_dump($test);
var_dump(cutLineBySpaces($test, 9));
