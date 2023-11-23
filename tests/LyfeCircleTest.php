<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LyfeCircleTest extends KernelTestCase
{
    private ContainerInterface $container;
    public function setUp():void{

        self::bootKernel();
        $this->container = static::getContainer();
    }
    public function testLifeCycling(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
