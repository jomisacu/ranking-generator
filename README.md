# ranking-generator

A simple way to create rankings

## What is a ranking?

A ranking is a list that determines which items are higher and lower than others in a given aspect. For example, you can
have a set of video camera models and list them based on the quality of the video produced.

It's not just about listing by number. There are general classifications based on multiple aspects, for example, we
could have a classification called "the 10 best smartphones of 2022", where the place in the ranking would be given by
the combination of multiple factors.

## Installation

The most simple way to install this package is with composer:
```shell
composer require jomisacu/ranking-generator
```

## How to use this library?

There are two ways to use this library. First, we can convert our objects into "rankable". That is, implements the
RankableItemInterface interface. These objects can be used to create an instance of the Ranking class and that's it.

To help in the implementation we have added the RankableItemTrait. Let's see an example:

```php
<?php

use Jomisacu\RankingGenerator\Contracts\RankableItemInterface;
use Jomisacu\RankingGenerator\RankableItemTrait;

final class VideoCamera implements RankableItemInterface
{
    use RankableItemTrait;
    
    private int $pixels; // 1090
    private string $modelName; // Ej. 'Xiaomi camera xyz';

    public function __construct(string $modelName, int $pixels)
    {
        $this->modelName = $modelName;
        $this->pixels = $pixels;
    }

    public function getValue()
    {
        return $this->pixels;
    }

    protected function getUniqueDomainIdentifier(): string
    {
        return $this->modelName;
    }

    protected function computeRating(): \Jomisacu\RankingGenerator\Rating
    {
        $maxPixelsPossible = 4000;

        return new Rating($this->getValue() * 100 / $maxPixelsPossible); // ensures return a value between 1 and 100
    }
}



```

Second, using a ranking generator. In certain situations it is possible to require complex calculations to generate the
ranking. For these cases we have provided the RankingGeneratorInterface contract, which provides the build method that
receives a collection of arbitrary items and returns a collection of RankableItemInterface objects. In these cases it is
totally valid to use the RankingItem generic class instead of modifying our business objects, very useful when you need
multiple rankings based on the same items.

```php
<?php

class MyRankingGenerator implements \Jomisacu\RankingGenerator\Contracts\RankingGeneratorInterface
{
    public function build(array $items) : array
    {
        $final = [];
        
        foreach ($items as $item) {
            $alreadyComputedRating = $this->someComplexLogic($item);
            
            $final[] = new \Jomisacu\RankingGenerator\RankingItem(
                $item['value_used_to_compute_the_rating'],
                $item['name_to_identify_the_item_in_the_context'],
                $alreadyComputedRating,
            );
        }  
        
        return $final;
    }  
        
    function someComplexLogic(array $item): \Jomisacu\RankingGenerator\Rating
    {
        // complex logic implementation
    }
}

```

The RankingItem class is very simple. You can generate a rating based on the input, or you can use a pre-computed value.
