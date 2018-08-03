<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver;

interface GoogleShoppingCategoriesResolver
{
    public function get(): array;
}
