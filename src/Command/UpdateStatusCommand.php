<?php

namespace App\Command;

use App\Enum\Status;
use App\Repository\AuctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'update-status',
    description: 'Add a short description for your command',
)]
class UpdateStatusCommand extends Command
{
    public function __construct(private AuctionRepository $auctionRepository, EntityManagerInterface $em)
    {
        parent::__construct();

    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
      //  $this->auctionRepository->findAll();

        $io = new SymfonyStyle($input, $output);
        $io->note('Starting ManageStatusCommand...');

        //statut NEW & dateOpen dépassée
        $visibleAuctions = $this->auctionRepository->findVisibleAuctions();
       // dd($visibleAuctions);
        foreach ($visibleAuctions as $auction) {
            $now = new \DateTime();
            if ($auction->getDateOpen() <= $now) {
                $auction->setStatus(Status::VISIBLE);
                $this->auctionRepository->save($auction);
                $io->success(sprintf('Auction %d status changed to VISIBLE.' , $auction->getId()));
            }
        }

        $terminatingAuctions = $this->auctionRepository->findTerminatingAuctions();
        foreach ($terminatingAuctions as $auction) {
            $now = new \DateTime();
            if ($auction->getDateClose() <= $now) {
                $auction->setStatus(Status::TERMINATED);
                $this->auctionRepository->save($auction);
                $io->success(sprintf('Auction %d status changed to TERMINATED.' , $auction->getId()));
            }
        }

        //statut terminated & date closed depasse depuis 3 mois
        $archivingAuctions = $this->auctionRepository->findArchivingAuctions();
        foreach ($archivingAuctions as $auction) {
            $now = new \DateTime();
            $threeMonthsAgo = $now->modify('-3 months');
            if ($auction->getDateClose() <= $threeMonthsAgo) {
                $auction->setStatus(Status::ARCHIVED);
                $this->auctionRepository->save($auction);
                $io->success(sprintf('Auction %d status changed to ARCHIVED.' , $auction->getId()));
            }
        }

        return Command::SUCCESS;
    }
}
