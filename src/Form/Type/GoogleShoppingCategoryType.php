<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Form\Type;

use StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Resolver\GoogleShoppingCategoriesResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class GoogleShoppingCategoryType extends AbstractType
{
    /** @var GoogleShoppingCategoriesResolver */
    private $categoriesResolver;

    public function __construct(
        GoogleShoppingCategoriesResolver $categoriesResolver
    ) {
        $this->categoriesResolver = $categoriesResolver;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choice_loader' => new CallbackChoiceLoader(function () {
                return array_flip($this->categoriesResolver->get());
            }),
            'choice_label' => function ($choiceValue, $key, $value) {
                return $key;
            },
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
