<?php

declare(strict_types=1);

namespace StefanDoorn\GoogleShoppingCategoryFormTypeBundle\Downloader;

interface GoogleShoppingCategoryListDownloader
{
    public function fetch(): string;
}
