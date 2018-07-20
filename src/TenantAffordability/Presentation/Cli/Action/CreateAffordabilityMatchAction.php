<?php declare(strict_types=1);

namespace GoodLord\TenantAffordability\Presentation\Cli\Action;

use GoodLord\TenantAffordability\Application\Service\AffordabilityCheckService;
use GoodLord\TenantAffordability\Presentation\AbstractCommand;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;

class CreateAffordabilityMatchAction extends AbstractCommand
{
    private static $failureMessage = "A problem occurred while calculating your affordability score.";

    private $affordabilityCheckService;

    private $errorLogger;

    public function __construct(
        AffordabilityCheckService $affordabilityCheckService,
        LoggerInterface $errorLogger
    ) {
        parent::__construct('tenant:affordability_check');

        $this->affordabilityCheckService = $affordabilityCheckService;
        $this->errorLogger = $errorLogger;
    }

    /** @inheritdoc */
    public function configure()
    {
        $this->setDescription(
            'Calculate and display an affordability match between a tenant'
            . ' (based on their bank statement) and a list of properties.'
        );

        $this->addArgument(
            'bank_statement',
            InputArgument::REQUIRED,
            "Path to the tenant's bank statement file."
        );

        $this->addArgument(
            'property_list',
            InputArgument::REQUIRED,
            'Path to the list of properties to check.'
        );
    }


    protected function process(): int
    {
        $bankStatementFilePath = $this->input->getArgument('bank_statement');
        $propertyListFilePath = $this->input->getArgument('property_list');

        try {
            $results = $this->affordabilityCheckService->affordabilityCheck($bankStatementFilePath,
                $propertyListFilePath);
        } catch (\InvalidArgumentException $exception) {
            $this->error(
                self::$failureMessage,
                [
                    'message' => $exception->getMessage(),
                ]
            );

            $this->errorLogger->error(
                $exception->getMessage(),
                [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );

            return 1;
        } catch (\Throwable $throwable) {
            $this->error(self::$failureMessage, [
                'message' => 'Please contact an administrator. (hint: check ./var/logs/errors.txt)',
            ]);

            $this->errorLogger->error(
                $throwable->getMessage(),
                [
                    'message' => $throwable->getMessage(),
                    'code' => $throwable->getCode(),
                    'file' => $throwable->getFile(),
                    'line' => $throwable->getLine(),
                ]
            );

            return 1;
        }


        $this->success('Affordability check completed successfully.');

        $table = new Table($this->output);

        $table->setHeaders(['address', 'affordable']);
        $table->setRows($results);

        $table->render();

        return 0;
    }
}
