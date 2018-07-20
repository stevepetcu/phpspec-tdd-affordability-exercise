<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Presentation;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractCommand extends Command
{
    /** @var  InputInterface */
    protected $input;

    /** @var  OutputInterface */
    protected $output;

    /** @var  SymfonyStyle */
    protected $style;

    abstract protected function process(): int;

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;
        $this->style = new SymfonyStyle($input, $output);

        return $this->process();
    }

    protected function success(string $message, array $context = []): void
    {
        $this->style->success($message);
        $this->displayContextAsTable($context);
    }

    protected function error(string $message, array $context = []): void
    {
        $this->style->error($message);
        $this->displayContextAsTable($context);
    }

    private function displayContextAsTable(array $context = [])
    {
        $this->style->table(array_keys($context), [array_values($context)]);
    }
}
