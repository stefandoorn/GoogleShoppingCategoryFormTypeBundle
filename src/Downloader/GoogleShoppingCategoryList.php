<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Downloader;

final class GoogleShoppingCategoryList implements GoogleShoppingCategoryListDownloader
{
    /**
     * @var string
     */
    private $locale;

    public function __construct(string $locale = 'en_US')
    {
        $this->locale = $locale;
    }

    public function fetch(): string
    {
        $data = file_get_contents(self::url($this->locale));

        if (false === $data) {
            throw new \Exception('Could not load Google Shopping Categories list');
        }

        return $data;
    }

    private static function url(string $locale): string
    {
        return sprintf('https://www.google.com/basepages/producttype/taxonomy-with-ids.%s.txt', self::locale($locale));
    }

    private static function locale(string $locale): string
    {
        return str_replace('_', '-', $locale);
    }
}
