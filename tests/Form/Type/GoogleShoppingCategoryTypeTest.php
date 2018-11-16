<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Tests\Form\Type;

use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Downloader\GoogleShoppingCategoryListDownloader;
use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Form\Type\GoogleShoppingCategoryType;
use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver\GoogleShoppingCategories;
use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver\GoogleShoppingCategoriesResolver;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

final class GoogleShoppingCategoryTypeTest extends TypeTestCase
{
    /** @var GoogleShoppingCategoryListDownloader|\PHPUnit\Framework\MockObject\MockObject */
    private $downloader;

    /** @var GoogleShoppingCategoriesResolver */
    private $resolver;

    protected function setUp()
    {
        $this->downloader = $this->getMockBuilder(GoogleShoppingCategoryListDownloader::class)->getMock();
        $this->downloader->expects($this->once())->method('fetch')->willReturn(file_get_contents(__DIR__ . '/../../_data/list.txt'));

        $this->resolver = new GoogleShoppingCategories($this->downloader);

        parent::setUp();
    }

    protected function getExtensions()
    {
        $type = new GoogleShoppingCategoryType($this->resolver);

        return [
            new PreloadedExtension([$type], []),
        ];
    }

    public function testFormType()
    {
        $form = $this->factory->create(GoogleShoppingCategoryType::class);

        /** @var CallbackChoiceLoader $choiceLoader */
        $choiceLoader = $form->getConfig()->getOption('choice_loader');
        $this->assertInstanceOf(CallbackChoiceLoader::class, $choiceLoader);

        $choices = $choiceLoader->loadChoiceList();
        $this->assertInstanceOf(ArrayChoiceList::class, $choices);

        $this->assertCount(5427, $choices->getChoices());
    }
}
