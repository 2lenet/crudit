<?php

declare(strict_types=1);

namespace Lle\CruditBundle\Controller;

use Lle\CruditBundle\Brick\BrickResponseCollector;
use Lle\CruditBundle\Builder\BrickBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractCrudController extends AbstractController
{
    public static function getSubscribedServices()
    {
        $subscribeds = parent::getSubscribedServices();
        $subscribeds[BrickBuilder::class] = '?' . BrickBuilder::class;
        $subscribeds[SerializerInterface::class] = '?' . SerializerInterface::class;
        $subscribeds[BrickResponseCollector::class] = '?' . BrickResponseCollector::class;
        return $subscribeds;
    }

    public function getBrickBuilder(): object
    {
        return $this->get(BrickBuilder::class);
    }

    public function getSerializer(): object
    {
        return $this->get(SerializerInterface::class);
    }

    public function getBrickResponseCollector(): object
    {
        return $this->get(BrickResponseCollector::class);
    }
}
