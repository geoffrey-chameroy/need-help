<?php

namespace App\Factory;

use App\Entity\Job;
use App\Entity\User;

class JobFactory
{
    public function create(User $createdBy, string $title, string $description, ?string $status = null): Job
    {
        // default pending status
        $status = $status ?: Job::STATUS_PENDING;

        return (new Job())
            ->setCreatedBy($createdBy)
            ->setTitle($title)
            ->setDescription($description)
            ->setStatus($status);
    }
}
