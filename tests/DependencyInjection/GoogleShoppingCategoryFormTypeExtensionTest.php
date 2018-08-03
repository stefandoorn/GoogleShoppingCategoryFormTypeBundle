<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\DependencyInjection\GoogleShoppingCategoryFormTypeExtension;

final class GoogleShoppingCategoryFormTypeExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return [
            new GoogleShoppingCategoryFormTypeExtension(),
        ];
    }

    /**
     * @dataProvider serviceList
     */
    public function testServiceExists(string $service): void
    {
        $this->load();

        $this->assertContainerBuilderHasService($service);
    }

    public function serviceList(): array
    {
        return [
            ['google_shopping_category.resolver.categories'],
            ['google_shopping_category.resolver.categories_cached'],
            ['google_shopping_category.form.category'],
            ['google_shopping_category.downloader.category'],
        ];
    }
}
