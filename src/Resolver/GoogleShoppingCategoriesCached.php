<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver;

use Symfony\Component\Cache\Adapter\AdapterInterface;

final class GoogleShoppingCategoriesCached implements GoogleShoppingCategoriesResolver
{
    /**
     * @var GoogleShoppingCategoriesResolver
     */
    private $resolver;

    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @var int
     */
    private $ttl = 86400;

    public function __construct(
        GoogleShoppingCategoriesResolver $googleShoppingCategoriesResolver,
        AdapterInterface $cacheAdapter,
        ?int $ttl = null
    ) {
        $this->resolver = $googleShoppingCategoriesResolver;
        $this->cache = $cacheAdapter;

        if (null !== $ttl) {
            $this->ttl = $ttl;
        }
    }

    public function get(): array
    {
        $cacheKey = str_replace('\\', '_', self::class);
        $cache = $this->cache->getItem($cacheKey);

        if (!$cache->isHit()) {
            $data = $this->resolver->get();

            $cache
              ->set($data)
              ->expiresAfter($this->ttl);

            $this->cache->save($cache);
        }

        return $cache->get();
    }
}
