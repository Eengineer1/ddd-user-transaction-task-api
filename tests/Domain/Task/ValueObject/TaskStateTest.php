<?php

namespace Tests\Leos\Domain\Task\ValueObject;

use Leos\Domain\Task\ValueObject\TaskState;
use PHPUnit\Framework\TestCase;

/**
 * Class TaskStateTest
 *
 * @package Tests\Leos\Domain\Task\Model
 */
class TaskStateTest extends TestCase
{
    /**
     * @group unit
     */
    public function testStates()
    {
        self::assertTrue(is_array(TaskState::states()));
        self::assertTrue(in_array('to-do', TaskState::states()));
        self::assertTrue(in_array('in-progress', TaskState::states()));
        self::assertTrue(in_array('done', TaskState::states()));
        self::assertTrue(in_array('cancelled', TaskState::states()));
    }

    /**
     * @group unit
     */
    public function testGetters()
    {
        $type = new TaskState(TaskState::TODO);

        self::assertEquals(TaskState::TODO, (string) $type);
    }

    /**
     * @group unit
     */
    public function testValidation()
    {
        self::assertFalse(TaskState::isValid('Happy'));
    }

    /**
     * @group unit
     */
    public function testConstructValidation()
    {
        try {

            new TaskState('Happy');

            self::assertTrue(false);

        } catch (\Exception $e) {

            self::assertTrue(true);
        }
    }
}
