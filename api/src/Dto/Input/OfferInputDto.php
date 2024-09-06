<?php

namespace App\Dto\Input;

use Symfony\Component\Validator\Constraints as Assert;

class OfferInputDto
{
    #[Assert\GreaterThan(0)]
    private float $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
