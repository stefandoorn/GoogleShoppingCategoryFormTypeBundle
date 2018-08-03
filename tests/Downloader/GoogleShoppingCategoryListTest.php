<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Tests\Downloader;

use PHPUnit\Framework\TestCase;
use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Downloader\GoogleShoppingCategoryList;

final class GoogleShoppingCategoryListTest extends TestCase
{
    /**
     * @dataProvider getLocales
     */
    // Normally would not want to download external files, but here we like to check the service still works as expected
    public function testFetch(string $locale): void
    {
        $downloader = new GoogleShoppingCategoryList($locale);

        $this->assertNotEmpty($downloader->fetch());
    }

    public function getLocales(): array
    {
        return [
            ['nl_NL'],
            ['en_US'],
        ];
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Could not load Google Shopping Categories list for locale
     */
    public function testInvalidLocale(): void
    {
        $downloader = new GoogleShoppingCategoryList('test');
        $downloader->fetch();
    }
}
