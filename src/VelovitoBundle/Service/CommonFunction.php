<?php
namespace VelovitoBundle\Service;

use VelovitoBundle\C;

class CommonFunction
{
    private $statusMap = [
        C::AD_STATUS_DRAFT     => 'Черновик',
        C::AD_STATUS_PUBLISHED => 'Опубликовано',
        C::AD_STATUS_DELETED   => 'Снято с публикации',
    ];
}