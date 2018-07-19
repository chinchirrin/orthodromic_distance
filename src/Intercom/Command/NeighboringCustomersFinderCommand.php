<?php
namespace Intercom\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class NeighboringCustomersFinderCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('intercom:search:customers')
            ->setDescription('Display the list of neighboring customers within configured radio')
            ->setHelp('This command allows to search for users near the office')
            ->addOption(
                'radius',
                null,
                InputOption::VALUE_REQUIRED,
                'Distance in Km to filter out customers based on their location',
                100.0
            )
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

        $radius = (float) $input->getOption('radius');
        if (!$radius) {
            $output->writeln('Invalid value for radius, please make sure you input a valid distance value.');
            return;
        }

        $potential_invitees = $planner->gatherPotentialInviteesWithinRadius($radius);
        $this->print($output, $potential_invitees, $radius);
    }

    protected function print(OutputInterface $output, array $data, $radius)
    {
        $output->writeln("Customers within $radius Km radius:");
        foreach ($data as $row) {
            $output->writeln('UserId: ' . $row['user_id'] . '; Name: ' . $row['name']);
        }
    }
}

