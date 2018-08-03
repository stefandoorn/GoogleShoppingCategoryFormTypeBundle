<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver;

final class GoogleShoppingCategories implements GoogleShoppingCategoriesResolver
{
    /**
     * @var string
     */
    private $locale;

    public function __construct(string $locale = 'en_US')
    {
        $this->locale = $locale;
    }

    public function get(): array
    {
        $data = file_get_contents(self::url($this->locale));

        if (false === $data) {
            throw new \Exception('Could not load Google Shopping Categories list');
        }

        $categories = [];

        foreach (explode(PHP_EOL, $data) as $key => $line) {
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

    private static function url(string $locale): string
    {
        return sprintf('https://www.google.com/basepages/producttype/taxonomy-with-ids.%s.txt', self::locale($locale));
    }

    private static function locale(string $locale): string
    {
        return str_replace('_', '-', $locale);
    }
}
