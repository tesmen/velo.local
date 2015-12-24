<?php

namespace AppBundle\Entity;

use AppBundle\C;

class ReferenceEntityType
{
    public function getType()
    {
        return C::ENTITY_TYPE_REFERENCE;
    }
}
