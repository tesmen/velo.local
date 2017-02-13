<?php

namespace VelovitoBundle\Twig;

use VelovitoBundle\Service\CommonFunction;

/**
 * Example: {{ (users_count ~ " пользовател")|plural("ь", "я", "ей") }}
 * @license BSD
 */
class PluralExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'plural';
    }

    public function getFilters()
    {
        return [
            'plural'  => new \Twig_SimpleFilter('plural', [$this, 'plural']),
            'nplural' => new \Twig_SimpleFilter('nplural', [$this, 'nplural']),
        ];
    }

    /**
     * @deprecated
     */
    public function nplural($text, $e1, $e2, $e3, $digit)
    {
        $digit = intval($digit);

        $digit = ($digit > 20) ? $digit % 10 : $digit;
        if ($digit >= 5 || $digit == 0) {
            return $text . ' ' . $e3;
        }
        if ($digit >= 2) {
            return $text . ' ' . $e2;
        }

        return $text . ' ' . $e1;
    }

    /*
     * usage {{ order.expire | plural("день", "дня", "дней") }}
     * $returnNumber = true -> "29 дней"
     * $returnNumber = false -> "дней"
     */
    public function plural($number, $e1, $e2, $e3, $returnNumber = true)
    {
        return CommonFunction::nplural((Int)$number, $e1, $e2, $e3, $returnNumber);
    }
}
