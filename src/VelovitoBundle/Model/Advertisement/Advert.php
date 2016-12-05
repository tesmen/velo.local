<?php

namespace VelovitoBundle\Model\Advertisement;

use VelovitoBundle\Entity\Advertisement;

class Advert
{
    public $title;
    public $description;
    public $price;
    public $currency;
    public $created;
    public $viewsCount;

    public $category;
    public $product;

    public function __construct(Advertisement $advertisement, $category, $product)
    {
        $this->title = $advertisement->getTitle();
        $this->description = $advertisement->getDescription();
        $this->price = $advertisement->getPrice();
        $this->currency = $advertisement->getCurrency();
        $this->created = $advertisement->getCreated();
        $this->viewsCount = $advertisement->getViewsCount();

        $this->category = $category;
        $this->product = $product;
    }
}
