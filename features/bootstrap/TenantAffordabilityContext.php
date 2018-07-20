<?php declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use GoodLord\TenantAffordability\Presentation\Cli\Action\CreateAffordabilityMatchAction;
use PHPUnit\Framework\Assert;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Tester\CommandTester;

class TenantAffordabilityContext implements Context
{
    /** @var  ContainerInterface */
    private $container;

    /** @var CreateAffordabilityMatchAction */
    private $affordabilityMatchCommand;

    /** @var CommandTester */
    private $commandTester;

    private $bankStatementFilePath;

    private $propertiesListFilePath;

    public function __construct()
    {
        require 'bootstrap.php';

        $this->container = require PATH_ROOT . '/bootstrap/container.php';

        $this->affordabilityMatchCommand = $this->container->get(CreateAffordabilityMatchAction::class);

        $this->commandTester = new CommandTester($this->affordabilityMatchCommand);
    }

    /**
     * @Given my bank statement file is located at :path
     */
    public function setBankStatementFilePath(string $path)
    {
        $this->bankStatementFilePath = $path;
    }

    /**
     * @Given the properties list file is located at :path
     */
    public function setPropertiesListFilePath(string $path)
    {
        $this->propertiesListFilePath = $path;
    }

    /**
     * @When I perform the affordability check
     */
    public function iPerformTheAffordabilityCheck()
    {
        $this->commandTester->execute([
            'bank_statement' => PATH_ROOT . $this->bankStatementFilePath,
            'property_list' => PATH_ROOT . $this->propertiesListFilePath
        ]);
    }

    /**
     * @Then the result should be successful
     */
    public function theResultShouldBeSuccessful()
    {
        Assert::assertContains(
            '[OK] Affordability check completed successfully.',
            $this->commandTester->getDisplay(),
            'Affordability check should contain successfully completed message.'
        );
    }

    /**
     * @Then the displayed message should contain the evaluated property results:
     */
    public function theResultShouldBe(TableNode $expectedResults)
    {
        $results = $this->commandTester->getDisplay();

        foreach ($expectedResults->getHash() as $row) {
            Assert::assertContains(
                trim($row['address'], '\"') . ' | ' . $row['affordable'],
                $results,
                "Unexpected result for property at {$row['address']}."
            );
        }
    }

    /**
     * @Then the result should be unsuccessful
     */
    public function theResultShouldBeUnsuccessful()
    {
        Assert::assertContains(
            '[ERROR] A problem occurred while calculating your affordability score.',
            $this->commandTester->getDisplay(),
            'Affordability check should contain successfully completed message.'
        );
    }

    /**
     * @Then the displayed message should contain the text :text
     */
    public function theDisplayedMessageShouldContainTheText(string $text)
    {
        Assert::assertContains(
            $text,
            $this->commandTester->getDisplay(),
            "Displayed message should contain: $text"
        );
    }
}
