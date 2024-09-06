<?php

namespace App\Service;

use App\Dto\Input\JobInputDto;
use App\Entity\Job;
use App\Entity\Offer;
use App\Entity\User;
use App\Factory\JobFactory;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;

class JobService
{
    public function __construct(
        private readonly JobFactory $jobFactory,
        private readonly EntityManagerInterface $entityManager,
        private readonly JobRepository $jobRepository,
    )
    {
    }

    public function create(User $createdBy, JobInputDto $inputDto): Job
    {
        $job = $this->jobFactory->create(
            $createdBy,
            $inputDto->getTitle(),
            $inputDto->getDescription()
        );

        $this->entityManager->persist($job);
        $this->entityManager->flush();

        return $job;
    }

    public function getList(int $page = 1): array
    {
        $page = max($page, 1);

        // todo: pagination
        return $this->jobRepository->findAll();
    }

    public function update(Job $job, JobInputDto $inputDto): Job
    {
        $job->setTitle($inputDto->getTitle())
            ->setDescription($inputDto->getDescription());

        $this->entityManager->persist($job);
        $this->entityManager->flush();

        return $job;
    }

    public function cancel(Job $job): Job
    {
        if ($job->getStatus() === Job::STATUS_DONE) {
            throw new \Exception('This job is already done.');
        }

        // job already cancelled
        if ($job->getStatus() === Job::STATUS_CANCELLED) {
            return $job;
        }

        // todo: send cancelled job email success
        $job->setStatus(Job::STATUS_CANCELLED);
        $this->entityManager->persist($job);

        // reject all offers
        foreach ($job->getOffers() as $rejectedOffer) {
            // todo: send cancelled job email
            $rejectedOffer->setStatus(Offer::STATUS_REJECTED);
            $this->entityManager->persist($rejectedOffer);
        }

        $this->entityManager->flush();

        return $job;
    }
}
