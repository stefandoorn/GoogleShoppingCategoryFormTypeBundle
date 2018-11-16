<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Tests\Resolver;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver\GoogleShoppingCategoriesCached;
use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver\GoogleShoppingCategoriesResolver;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class GoogleShoppingCategoriesCachedTest extends TestCase
{
    /** @var GoogleShoppingCategoriesResolver|\PHPUnit\Framework\MockObject\MockObject */
    private $resolver;

    /** @var AdapterInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $cache;

    /** @var CacheItemInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $item;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->resolver = $this->getMockBuilder(GoogleShoppingCategoriesResolver::class)->getMock();
        $this->resolver->expects($this->once())->method('get')->willReturn(['123' => 'test']);

        $this->item = $this->getMockBuilder(CacheItemInterface::class)->getMock();
        $this->item->expects($this->exactly(2))->method('isHit')->willReturnOnConsecutiveCalls(false, true);
        $this->item->expects($this->once())->method('set')->willReturnSelf();
        $this->item->expects($this->exactly(2))->method('get')->willReturn(['123' => 'test']);

        $this->cache = $this->getMockBuilder(AdapterInterface::class)->getMock();
        $this->cache->expects($this->exactly(2))->method('getItem')->willReturn($this->item);

        parent::setUp();
    }

    public function testSingleRender()
    {
        $cachedResolver = new GoogleShoppingCategoriesCached($this->resolver, $this->cache);

        // Call resolver twice, second result should not trigger a new resolve call but return from cache
        $cachedResolver->get();
        $cachedResolver->get();
    }
}
