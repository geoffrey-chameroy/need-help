<?php

namespace App\DataFixtures;

use App\Entity\Job;
use App\Entity\User;
use App\Factory\JobFactory;
use App\Factory\OfferFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserFactory $userFactory,
        private readonly JobFactory $jobFactory,
        private readonly OfferFactory $offerFactory,
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userFactory->create(
            'jobber@needhelp.fr',
            'Jobber',
            'password',
            [User::ROLE_USER, User::ROLE_JOBBER],
        );
        $manager->persist($user);


        $faker = Factory::create();
        for ($i = 0; $i < 20; ++$i) {
            $job = $this->jobFactory->create(
                $user,
                $faker->text(50),
                $faker->text(300),
            );
            $manager->persist($job);
            for ($j = 0; $j < 5; ++$j) {
                $offer = $this->offerFactory->create(
                    $job,
                    $user,
                    $faker->randomFloat(0, 25, 50),
                );
                $manager->persist($offer);
            }
        }

        $manager->flush();
    }
}
