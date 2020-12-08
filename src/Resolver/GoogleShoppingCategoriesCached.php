<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver;

use Symfony\Component\Cache\Adapter\AdapterInterface;

final class GoogleShoppingCategoriesCached implements GoogleShoppingCategoriesResolver
{
    /** @var GoogleShoppingCategoriesResolver */
    private $resolver;

    /** @var AdapterInterface */
    private $cache;

    /** @var int|null */
    private $ttl;

    public function __construct(
        GoogleShoppingCategoriesResolver $googleShoppingCategoriesResolver,
        AdapterInterface $cacheAdapter,
        ?int $ttl = 86400
    ) {
        $this->resolver = $googleShoppingCategoriesResolver;
        $this->cache = $cacheAdapter;
        $this->ttl = $ttl;
    }

    /**
     * @return string[]
     */
    public function get(): array
    {
        $cacheKey = str_replace('\\', '_', self::class);
        $cache = $this->cache->getItem($cacheKey);

        if (!$cache->isHit()) {
            $data = $this->resolver->get();

            $cache->set($data);

            if ($this->ttl) {
                $cache->expiresAfter($this->ttl);
            }

            $this->cache->save($cache);
        }

        return $cache->get();
    }
}
