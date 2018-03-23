<?php

declare(strict_types=1);

namespace Tests\Brille24\CustomerOptionsPlugin\PHPUnit\Entity;

use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\Validator\Condition;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\Validator\Constraint;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\Validator\Validator;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /** @var ValidatorInterface */
    private $validator;

    public function setUp()
    {
        $this->validator = new Validator();
        $this->validator->getErrorMessage()->setCurrentLocale('en_US');
    }

    /**
     * @test
     */
    public function testDefaultValues()
    {
        self::assertCount(0, $this->validator->getConditions());
        self::assertCount(0, $this->validator->getConstraints());
        self::assertEquals(Validator::DEFAULT_ERROR_MESSAGE, $this->validator->getErrorMessage()->getMessage());
    }

    /**
     * @test
     */
    public function testAddConditions()
    {
        $num = 5;

        for ($i = 0; $i < $num; ++$i) {
            $condition = self::createMock(Condition::class);

            $this->validator->addCondition($condition);

            self::assertCount($i + 1, $this->validator->getConditions());
        }

        return $this->validator;
    }

    /**
     * @test
     * @depends testAddConditions
     */
    public function testRemoveConditions(Validator $validator)
    {
        $count = $validator->getConditions()->count();
        $condition = $validator->getConditions()->first();

        $validator->removeCondition($condition);

        self::assertCount($count - 1, $validator->getConditions());
    }

    /**
     * @test
     */
    public function testAddConstraints()
    {
        $num = 5;

        for ($i = 0; $i < $num; ++$i) {
            $constraint = self::createMock(Constraint::class);

            $this->validator->addConstraint($constraint);

            self::assertCount($i + 1, $this->validator->getConstraints());
        }

        return $this->validator;
    }

    /**
     * @test
     * @depends testAddConstraints
     */
    public function testRemoveConstraint(Validator $validator)
    {
        $count = $validator->getConstraints()->count();
        $constraint = $validator->getConstraints()->first();

        $validator->removeConstraint($constraint);

        self::assertCount($count - 1, $validator->getConstraints());
    }
}
