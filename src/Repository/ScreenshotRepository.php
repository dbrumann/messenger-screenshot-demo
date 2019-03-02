<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Screenshot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ScreenshotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Screenshot::class);
    }

    public function findScreenshot(string $id): ?Screenshot
    {
        return $this->find($id);
    }

    /**
     * @return Screenshot[]
     */
    public function findAllScreenshots(): array
    {
        return $this->findAll();
    }
}
