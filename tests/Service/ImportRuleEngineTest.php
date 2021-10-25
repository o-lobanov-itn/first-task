<?php

namespace App\Tests\Service;

use App\Domain\ImportRule\RuleInterface;
use App\Entity\ProductData;
use App\Service\ImportRuleEngine;
use PHPUnit\Framework\TestCase;

class ImportRuleEngineTest extends TestCase
{
    public function testValidateOk(): void
    {
        $engine = new ImportRuleEngine();

        $rule = $this->createStub(RuleInterface::class);
        $rule->method('isImportable')->willReturn(true);
        $engine->addRule($rule);

        self::assertCount(0, $engine->validate(new ProductData()));
    }

    public function testValidateFailure(): void
    {
        $engine = new ImportRuleEngine();
        $ruleDescription = 'Rule description';

        $rule = $this->createStub(RuleInterface::class);
        $rule->method('isImportable')->willReturn(false);
        $rule->method('getDescription')->willReturn($ruleDescription);
        $engine->addRule($rule);

        $errors = $engine->validate(new ProductData());
        self::assertCount(1, $errors);
        self::assertEquals($ruleDescription, $errors[0]);
    }
}
