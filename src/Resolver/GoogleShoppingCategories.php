<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver;

use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Downloader\GoogleShoppingCategoryListDownloader;

final class GoogleShoppingCategories implements GoogleShoppingCategoriesResolver
{
    /**
     * @var GoogleShoppingCategoryListDownloader
     */
    private $downloader;

    public function __construct(GoogleShoppingCategoryListDownloader $categoryListDownloader)
    {
        $this->downloader = $categoryListDownloader;
    }

    public function get(): array
    {
        $categories = [];

        foreach (explode(PHP_EOL, $this->downloader->fetch()) as $key => $line) {
            if ('' === $line) {
                continue;
            }

            if ('#' === substr($line, 0, 1)) {
                continue;
            }

            [$id, $text] = explode(' - ', $line);

            $categories[(int) $id] = $text;
        }

        return $categories;
    }
}
