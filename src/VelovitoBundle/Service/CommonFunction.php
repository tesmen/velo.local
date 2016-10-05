<?php
namespace VelovitoBundle\Service;

use VelovitoBundle\Entity\AttributeReferenceItem;

class CommonFunction
{
    public static function cutLineWords($line, $requiredLength)
    {
        $line = trim($line);
        $textLength = $requiredLength - 3;
        $dots = '...';

        if (strlen($line) <= $requiredLength) {
            return $line;
        }

        $rawCut = substr($line, 0, $textLength);

        if ($rawCut[$textLength - 1] !== ' ') {
            $lastSpacePos = self::getLastSymbolPosition($rawCut, ' ');

            if (false === $lastSpacePos) {
                return $rawCut . $dots;
            }

            return trim(substr($rawCut, 0, $lastSpacePos )) . $dots;
        }

        return trim($rawCut) . $dots;
    }

    public static function getLastSymbolPosition($line, $symbol)
    {
        $symPos = strpos(strrev($line), $symbol);

        if (false === $symPos) {
            return false;
        }

        return strlen($line) - $symPos;
    }

    public static function entitiesToFormView($items, $field = 'Name', $appendNotSelected = false)
    {
        $result = [];
        $getter = 'get' . $field;

        foreach ($items as $item) {
            /**
             * @var $item AttributeReferenceItem
             */
            $result[$item->$getter()] = $item->getId();
        };

        ksort($result);

        if ($appendNotSelected) {
            $result = ['Не указано' => 'null'] + $result;
        }

        return $result;
    }

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

    public static function transliterate($stmt)
    {
        $converter = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ь' => '',
            'ы' => 'y',
            'ъ' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'E',
            'Ж' => 'Zh',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'Y',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'C',
            'Ч' => 'Ch',
            'Ш' => 'Sh',
            'Щ' => 'Sch',
            'Ь' => '',
            'Ы' => 'Y',
            'Ъ' => '',
            'Э' => 'E',
            'Ю' => 'Yu',
            'Я' => 'Ya',
        ];

        return strtr($stmt, $converter);
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
        if (!(filter_var('test@' . $domain, FILTER_VALIDATE_EMAIL))) {
            throw new \Exception('err_domain_not_valid');
        };

        return true;
    }

    public static function testDomainNameRegExp($domain)
    {
        $pattern = '/^([a-zA-Z0-9-]{1,32}\.){1,3}[a-zA-Z]{2,}$/';
        preg_match($pattern, $domain, $matches);

        return !empty($matches);
    }

    public static function testDomainNameRegExpRf($domain)
    {
        $pattern = '/^([а-яА-я-]{1,32}\.){1,3}рф$/u';
        preg_match($pattern, $domain, $matches);

        return !empty($matches);
    }

    public static function testDomainName($domain)
    {
        $valid = CommonFunction::testDomainNameRegExp($domain)
            || CommonFunction::testDomainNameRegExpRf($domain);

        return $valid;
    }

    public static function testDomainNameIntl($domain)
    {
        return filter_var('test@' . $domain, FILTER_VALIDATE_EMAIL);
    }

    public static function nplural($digit, $e1, $e2, $e3, $returnNumber = false)
    {
        $txt = $returnNumber ? (String)$digit . ' ' : '';
        $digit = ($digit > 20) ? $digit % 10 : $digit;

        if ($digit >= 5 || $digit == 0) {
            return $txt . $e3;
        }
        if ($digit >= 2) {
            return $txt . $e2;
        }

        return $txt . $e1;
    }

    public static function getFileExtension($fileName)
    {
        return CommonFunction::getDomainArea($fileName);
    }

    public static function getDomainArea($domain)
    {
        $pieces = explode('.', $domain);

        return array_pop($pieces);
    }
}