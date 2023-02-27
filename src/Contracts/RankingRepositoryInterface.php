<?php

declare(strict_types=1);

namespace Jomisacu\RankingGenerator\Contracts;

use Jomisacu\RankingGenerator\Ranking;

interface RankingRepositoryInterface
{
    public function findById(string $id): ?Ranking;

    public function save(Ranking $ranking): void;

    public function delete(Ranking $ranking): void;
}
