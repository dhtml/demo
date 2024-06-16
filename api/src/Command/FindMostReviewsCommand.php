<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\DBAL\Connection;

#[AsCommand(
    name: 'app:find-most-reviews',
    description: 'Add a short description for your command',
)]
class FindMostReviewsCommand extends Command
{
    private $connection;

    public function __construct(Connection $connection)
    {
        parent::__construct();

        $this->connection = $connection;
    }

    protected function configure()
    {
        $this
            ->setDescription('Displays the day or month with the highest number of reviews published')
            ->addOption('month', null, InputOption::VALUE_NONE, 'Display the month instead of the day');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $monthOption = $input->getOption('month');

        if ($monthOption) {
            $sql = "
                SELECT TO_CHAR(published_at, 'YYYY-MM') AS period, COUNT(*) AS review_count
                FROM review
                GROUP BY period
                ORDER BY review_count DESC, period DESC
                LIMIT 1
            ";
        } else {
            $sql = "
                SELECT TO_CHAR(published_at, 'YYYY-MM-DD') AS period, COUNT(*) AS review_count
                FROM review
                GROUP BY period
                ORDER BY review_count DESC, period DESC
                LIMIT 1
            ";
        }

        $stmt = $this->connection->executeQuery($sql);
        $result = $stmt->fetchAssociative();

        if ($result) {
            $period = $result['period'];
            $reviewCount = $result['review_count'];

            if ($monthOption) {
                $io->success("The month with the highest number of reviews is $period with $reviewCount reviews.");
            } else {
                $io->success("The day with the highest number of reviews is $period with $reviewCount reviews.");
            }
        } else {
            $io->warning('No reviews found.');
        }

        return Command::SUCCESS;
    }
}
