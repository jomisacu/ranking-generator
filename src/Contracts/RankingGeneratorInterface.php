<?php

declare(strict_types=1);

namespace Jomisacu\RankingGenerator\Contracts;

interface RankingGeneratorInterface
{
    /**
     * @return RankableItemInterface[]
     */
    public function build(array $items): array;
}
