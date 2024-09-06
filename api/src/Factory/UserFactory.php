<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function create(string $email, string $name, string $plainPassword, array $roles = []): User
    {
        $roles[] = User::ROLE_USER;
        $roles = array_unique($roles);

        $user = (new User())
            ->setEmail($email)
            ->setName($name)
            ->setRoles($roles);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plainPassword
        );
        $user->setPassword($hashedPassword);

        return $user;
    }
}
