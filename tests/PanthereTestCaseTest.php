<?php

namespace App\Tests;

use App\Entity\Auction;
use App\Repository\RaiseRepository;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PanthereTestCaseTest extends PantherTestCase
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
        //public function testSomething(): void
        public function testSomething( ): void
        {

      $client = static::createPantherClient();
       $crawler = $client->request('GET', '/');
       // attention l'id doit bien exister!
            $auctionId = 30;
           //  $form = $crawler->filter("form")->form(["raise_price"=>5000]);
            $form = $crawler->filter('#auction-'.$auctionId.' .sendButton')->form([
                "raise_price"=>5000
            ]);
        $client->submit($form);
       //si description est dans le 1er th
      $this->assertSelectorTextContains('#au', 'description');

       $this->assertSelectorTextContains('#update' . $auctionId, '5000');
       $this->assertSelectorTextContains('h1', 'Enchere en ligne');

    }
}
