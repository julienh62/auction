<?php

namespace App\Tests;

use App\Entity\Raise;
use App\Entity\Auction;
use App\Repository\RaiseRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RaiseTest extends KernelTestCase
{
      private ValidatorInterFace $validator;
      private RaiseRepository $raiseRepository;

    public function setUp():void
    {
        $kernel = self::bootKernel();
        //acceder au container de service
        $container = static::getContainer();

         $this->validator = $container->get(ValidatorInterface::class);
         $this->raiseRepository = $container->get(RaiseRepository::class);

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);

    }

    public function test_raise_egual_price(): void
    {
        $raise = new Raise();
        $raise->setPrice(0);

        $auction = new Auction();
        $auction->setPrice(0);
        $raise->setAuction($auction);
        $errors = $this->validator->validate($raise);
        //erreur attendue
        $this->assertNotEmpty($errors);
    }
    public function test_raise_sup_auction(): void
    {
        $raise = new Raise();
        $raise->setPrice(10000);

        $auction = new Auction();
        $auction->setPrice(0);
        $raise->setAuction($auction);
        $errors = $this->validator->validate($raise);
        //ici pas d'erreur attendue
        $this->assertEmpty($errors);
    }
    public function test_raise_inf_auction(): void
    {
        $raise = new Raise();
        $raise->setPrice(10);

        $auction = new Auction();
        $auction->setPrice(100);
        $raise->setAuction($auction);
        $errors = $this->validator->validate($raise);
        //pas erreur attendue
        $this->assertNotEmpty($errors);
    }

}
