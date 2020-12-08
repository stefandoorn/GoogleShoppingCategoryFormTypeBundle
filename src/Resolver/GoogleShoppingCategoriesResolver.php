<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver;

interface GoogleShoppingCategoriesResolver
{
    /**
     * @return string[]
     */
    public function get(): array;
}
