<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Tests\Resolver;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Downloader\GoogleShoppingCategoryListDownloader;
use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver\GoogleShoppingCategories;

final class GoogleShoppingCategoriesTest extends TestCase
{
    /**
     * @var MockObject|GoogleShoppingCategoryListDownloader
     */
    private $downloader;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->downloader = $this->getMockBuilder(GoogleShoppingCategoryListDownloader::class)->getMock();
        $this->downloader->expects($this->once())->method('fetch')->willReturn(file_get_contents(__DIR__ . '/../_data/list.txt'));

        parent::setUp();
    }

    public function testList()
    {
        $resolver = new GoogleShoppingCategories($this->downloader);

        $data = $resolver->get();

        $this->assertCount(5427, $data);
    }
}
