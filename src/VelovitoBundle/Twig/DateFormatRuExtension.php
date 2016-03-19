<?php

namespace VelovitoBundle\Twig;


class DateFormatRuExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'ru_date';
    }

    public function getFilters()
    {
        return ['ru_date' => new \Twig_Filter_Method($this, 'ruDateFormat')];
    }

    public function ruDateFormat($dateRaw)
    {
        if ($dateRaw instanceof \DateTime) {
            $dateTime = $dateRaw;
        } else {
            $dateTime = new \DateTime($dateRaw);
        }

        $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::NONE, \IntlDateFormatter::NONE);
        $formatter->setPattern('d MMMM YYYY');

        return $formatter->format($dateTime);
    }
}