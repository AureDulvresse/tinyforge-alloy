<?php

namespace Forge\Alloy\Console;

use Forge\Alloy\Alloy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AlloyCommand extends Command
{
    protected $alloy;

    public function __construct(Alloy $alloy)
    {
        parent::__construct();
        $this->alloy = $alloy;
    }

    protected function configure()
    {
        $this
            ->setName('alloy:execute')
            ->setDescription('Exécute une tâche sur un module d\'Alloy')
            ->addArgument('module', null, 'Nom du module à exécuter')
            ->addArgument('task', null, 'Nom de la tâche à exécuter');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $module = $input->getArgument('module');
        $task = $input->getArgument('task');

        try {
            $this->alloy->executeModuleTask($module, $task);
            $output->writeln("<info>Tâche {$task} sur le module {$module} exécutée avec succès !</info>");
        } catch (\Exception $e) {
            $output->writeln("<error>Erreur : {$e->getMessage()}</error>");
        }

        return Command::SUCCESS;
    }
}
