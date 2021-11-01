<?php

namespace App\Tests\Service;

use App\Domain\Import\Rules\RuleInterface;
use App\Entity\ProductData;
use App\Exception\Import\RuleCheckingException;
use App\Service\Import\RuleEngine;
use PHPUnit\Framework\TestCase;

class ImportRuleEngineTest extends TestCase
{
    /**
     * @throws RuleCheckingException
     */
    public function testValidateOk(): void
    {
        $engine = new RuleEngine([]);

        $rule = $this->createStub(RuleInterface::class);
        $rule->method('check');

        $engine->addRule($rule);

        $this->expectNotToPerformAssertions();
        $engine->check(new ProductData());
    }

    public function testValidateFailure(): void
    {
        $engine = new RuleEngine([]);
        $ruleDescription = 'Rule description';

        $rule = $this->createMock(RuleInterface::class);
        $rule->expects(self::once())
            ->method('check')
            ->will($this->throwException(new RuleCheckingException($ruleDescription)));

        $engine->addRule($rule);

        $this->expectException(RuleCheckingException::class);
        $this->expectExceptionMessage($ruleDescription);
        $engine->check(new ProductData());
    }
}
