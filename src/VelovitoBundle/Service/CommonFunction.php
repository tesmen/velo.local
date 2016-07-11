<?php
namespace VelovitoBundle\Service;

use VelovitoBundle\C;

class CommonFunction
{
    /* 1,l,0,O удалены из набора */
    public static function generateRawPassword($length = 8)
    {
        return substr(str_shuffle('abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789'), 0, $length);
    }

    /* 1,l,0,O удалены из набора */
    public static function generatePassword($length = 8)
    {
        $upperPattern = '/([A-Z])+/';
        $lowerPattern = '/([a-z])+/';
        $numberPattern = '/([0-9])+/';

        while (true) {
            $pass = CommonFunction::generateRawPassword($length);

            if (
                preg_match($upperPattern, $pass, $matches) &&
                preg_match($lowerPattern, $pass, $matches) &&
                preg_match($numberPattern, $pass, $matches)
            ) {
                break;
            }
        };

        return $pass;
    }


    public static function daysLeftByDateTime(\DateTime $dateTime)
    {
        $now = new \DateTime('now');

        if ($dateTime < $now) {
            return 0;
        }

        $diff = $dateTime->diff($now)->format('%a');

        return (Int)$diff === 0 ? 1 : (Int)$diff + 1;
    }

    public static function isExpired(\DateTime $dateTime)
    {
        return $dateTime < new \DateTime('now');
    }

    public static function checkDomainName($domain)
    {
        if (!(filter_var('test@'.$domain, FILTER_VALIDATE_EMAIL))) {
            throw new \Exception('err_domain_not_valid');
        };

        return true;
    }
}
