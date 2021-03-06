<?php

namespace VelovitoBundle\Twig;

class DaysAgoExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('days_ago', [$this, 'paramsFilter']),
        ];
    }

    public function paramsFilter($inputDate)
    {
        // todo there is smth wrong with $thatDay
        $thatDay = new \DateTime($inputDate->format('Y-m-j'));
        $days = date_diff($thatDay, new \DateTime('now'))->format('%a');

        switch ($days) {
            case 0:
                $word = 'сегодня';

                break;
            case 1:
                $word = 'вчера';

                break;
            default:
                $word = date_format($inputDate, 'd/m/y');
        }

        $date = $word . date_format($inputDate, ' в H:i');

        return $date;
    }

    public function getName()
    {
        return 'days_ago';
    }
}
