<?php
namespace Intercom\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NeighboringCustomersFinderCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('intercom:search:customers')
            ->setDescription('Display the list of neighboring customers within configured radio')
            ->setHelp('This command allows to search for users near the office')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = new \Intercom\Factory();
        try {
            $planner = $factory->create(\Intercom\SocialEvents\Planner::class);
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
            return;
        }

        $radius = 100.0;
        $potential_invitees = $planner->gatherPotentialInviteesWithinRadius($radius);
        $this->print($output, $potential_invitees);
    }

    protected function print(OutputInterface $output, array $data)
    {
        $output->writeln('Customers within 100km radius:');
        foreach ($data as $row) {
            $output->writeln('UserId: ' . $row['user_id'] . '; Name: ' . $row['name']);
        }
    }
}

