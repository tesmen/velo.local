<?php

namespace AppBundle\Model;

class BuyAd extends Ad
{
    private $ent;

    private $id;
    private $title;
    private $text;
    private $price;
    private $place;
    private $photos;

    public function __construct($ent)
    {
        $this->ent = $ent;
        $this->id = $ent->getId();
        $this->title = $ent->getTitle();
        $this->text = $ent->getText();
        $this->price = $ent->getPrice();
        $this->place = $ent->getPlace();
        $this->photos = $ent->getPhotos();
    }
}

