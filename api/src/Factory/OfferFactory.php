<?php

namespace App\Factory;

use App\Entity\Job;
use App\Entity\Offer;
use App\Entity\User;

class OfferFactory
{
    public function create(Job $job, User $jobber, float $amount, ?string $status = null): Offer
    {
        // default pending status
        $status = $status ?: Offer::STATUS_PENDING;

        return (new Offer())
            ->setJob($job)
            ->setJobber($jobber)
            ->setAmount($amount)
            ->setStatus($status);
    }
}
