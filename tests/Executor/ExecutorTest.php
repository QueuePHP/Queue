<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 27/12/15
 * Time: 20:19
 */

namespace Queue\Executor;


use Queue\Job\Job;

class ExecutorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CallbackExecutor
     */
    private $executor;

    protected function setUp()
    {
        $this->executor = new CallbackExecutor();
    }

    public function testNoCallback()
    {
        $job = new Job('test', []);

        $this->setExpectedException(\InvalidArgumentException::class);

        $this->executor->execute($job);
    }

    public function testInvalidCallback()
    {
        $job = new Job('test', ['callback' => 'nothing']);

        $this->setExpectedException(\InvalidArgumentException::class);

        $this->executor->execute($job);
    }

    public function testCallback()
    {
        $called = false;
        $callback = function() use (&$called) {
            return $called = true;
        };

        $job = new Job('test', ['callback' => $callback]);

        $this->executor->execute($job);

        $this->assertTrue($called);
    }

    public function testCallbackArguments()
    {
        $arguments = null;
        $callback = function($name, $data) use (&$arguments) {
            $arguments = func_get_args();
            return true;
        };

        $job = new Job('test', ['callback' => $callback]);

        $this->executor->execute($job);

        $this->assertEquals(['test', []], $arguments);
    }

    public function testCallbackReturn()
    {
        $callback = function() {
            return true;
        };

        $job = new Job('test', ['callback' => $callback]);

        $this->assertTrue($this->executor->execute($job));
    }
}
