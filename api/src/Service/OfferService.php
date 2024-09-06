<?php

namespace App\Service;

use App\Dto\Input\OfferInputDto;
use App\Entity\Job;
use App\Entity\Offer;
use App\Entity\User;
use App\Factory\OfferFactory;
use Doctrine\ORM\EntityManagerInterface;

class OfferService
{
    public function __construct(
        private readonly OfferFactory $offerFactory,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function create(Job $job, User $jobber, OfferInputDto $inputDto): Offer
    {
        if ($job->getStatus() !== Job::STATUS_PENDING) {
            throw new \Exception('This offer is not pending.');
        }

        $offer = $this->offerFactory->create(
            $job,
            $jobber,
            $inputDto->getAmount(),
        );

        $this->entityManager->persist($offer);
        $this->entityManager->flush();

        return $offer;
    }

    public function accept(Offer $acceptedOffer): Offer
    {
        $job = $acceptedOffer->getJob();
        if ($job->getStatus() !== Job::STATUS_PENDING) {
            throw new \Exception('This offer is not pending.');
        }

        // offer already accepted
        if ($acceptedOffer->getStatus() !== Offer::STATUS_ACCEPTED) {
            return $acceptedOffer;
        }

        // todo: send in progress job email
        $job->setStatus(Job::STATUS_IN_PROGRESS);
        $this->entityManager->persist($job);

        // todo: send accepted offer email
        $acceptedOffer->setStatus(Offer::STATUS_ACCEPTED);
        $this->entityManager->persist($acceptedOffer);

        // reject other offers
        foreach ($job->getOffers() as $rejectedOffer) {
            if ($rejectedOffer === $acceptedOffer) {
                continue;
            }
            // todo: send rejected offer email
            $rejectedOffer->setStatus(Offer::STATUS_REJECTED);
            $this->entityManager->persist($rejectedOffer);
        }

        $this->entityManager->flush();

        return $acceptedOffer;
    }

    public function reject(Offer $rejectedOffer): Offer
    {
        $job = $rejectedOffer->getJob();
        if ($job->getStatus() !== Job::STATUS_PENDING) {
            throw new \Exception('This offer is not pending.');
        }

        // offer already rejected
        if ($rejectedOffer->getStatus() !== Offer::STATUS_REJECTED) {
            return $rejectedOffer;
        }

        // todo: send rejected offer email
        $rejectedOffer->setStatus(Offer::STATUS_REJECTED);
        $this->entityManager->persist($rejectedOffer);

        return $rejectedOffer;
    }
}
