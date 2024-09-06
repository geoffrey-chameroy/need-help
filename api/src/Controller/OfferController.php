<?php

namespace App\Controller;

use App\Dto\Input\OfferInputDto;
use App\Entity\Job;
use App\Entity\Offer;
use App\Repository\UserRepository;
use App\Service\OfferService;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\View\View as ViewService;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OfferController extends AbstractApiController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly OfferService $offerService,
        private readonly UserRepository $userRepository,
    ) {
    }

    #[Route('/api/jobs/{id<\d+>}/offers', methods: ['POST'])]
    #[View(statusCode: 201, serializerGroups: ['offer:view'])]
    public function create(Job $job, #[MapRequestPayload] OfferInputDto $inputDto): ViewService|Offer
    {
        // todo: grant access only for ROLE_JOBBER
        $validationErrors = $this->validator->validate($inputDto);
        if (count($validationErrors) > 0) {
            return ViewService::create($validationErrors, 400);
        }

        // todo: create authentication
        $user = $this->userRepository->find(1);

        return $this->offerService->create($job, $user, $inputDto);
    }

    #[Route('/api/jobs/{id<\d+>}/offers/{offerId<\d+>}/accept', methods: ['POST'])]
    #[View(statusCode: 200, serializerGroups: ['offer:view'])]
    public function accept(Job $job, Offer $offer): Offer
    {
        // todo: check if the current user is the creator of the job
        return $this->offerService->accept($offer);
    }

    #[Route('/api/jobs/{id<\d+>}/offers/{offerId<\d+>}/reject', methods: ['POST'])]
    #[View(statusCode: 200, serializerGroups: ['offer:view'])]
    public function reject(Job $job, Offer $offer): Offer
    {
        // todo: check if the current user is the creator of the job
        return $this->offerService->reject($offer);
    }
}
