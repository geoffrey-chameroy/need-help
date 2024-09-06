<?php

namespace App\Controller;

use App\Dto\Input\JobInputDto;
use App\Entity\Job;
use App\Repository\UserRepository;
use App\Service\JobService;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\View\View as ViewService;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class JobController extends AbstractApiController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly JobService $jobService,
        private readonly UserRepository $userRepository,
    ) {
    }

    #[Route('/api/jobs', methods: ['POST'])]
    #[View(statusCode: 201, serializerGroups: ['job:view'])]
    public function create(#[MapRequestPayload] JobInputDto $inputDto): ViewService|Job
    {
        $validationErrors = $this->validator->validate($inputDto);
        if (count($validationErrors) > 0) {
            return ViewService::create($validationErrors, 400);
        }

        // todo: create authentication
        $user = $this->userRepository->find(1);

        return $this->jobService->create($user, $inputDto);
    }

    #[Route('/api/jobs', methods: ['GET'])]
    #[View(statusCode: 200, serializerGroups: ['job:view-list'])]
    public function getList(): array
    {
        // todo: Pagination
        return $this->jobService->getList(1);
    }

    #[Route('/api/jobs/{id<\d+>}', methods: ['GET'])]
    #[View(statusCode: 200, serializerGroups: ['job:view'])]
    public function get(Job $job): Job
    {
        return $job;
    }

    #[Route('/api/jobs/{id<\d+>}', methods: ['PUT'])]
    #[View(statusCode: 200, serializerGroups: ['job:view'])]
    public function update(Job $job, #[MapRequestPayload] JobInputDto $inputDto): ViewService|Job
    {
        // todo: check if the current user is the creator of the job
        $validationErrors = $this->validator->validate($inputDto);
        if (count($validationErrors) > 0) {
            return ViewService::create($validationErrors, 400);
        }

        return $this->jobService->update($job, $inputDto);
    }

    #[Route('/api/jobs/{id<\d+>}', methods: ['POST'])]
    #[View(statusCode: 200, serializerGroups: ['job:view'])]
    public function cancel(Job $job): Job
    {
        // todo: check if the current user is the creator of the job
        return $this->jobService->cancel($job);
    }
}
