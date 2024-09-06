<?php

namespace App\Dto\Input;

use Symfony\Component\Validator\Constraints as Assert;

class JobInputDto
{
    #[Assert\NotBlank]
    private string $title;

    #[Assert\NotBlank]
    private string $description;

    public function __construct(string $title, string $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
