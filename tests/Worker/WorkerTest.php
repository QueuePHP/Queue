<?php

/**
 * This file is part of the Queue package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Queue\Worker;

use Psr\Log\LoggerInterface;
use Queue\Driver\DriverInterface;
use Queue\Executor\JobExecutorInterface;
use Queue\Helpers\JobExecutor;
use Queue\Job\Job;
use Queue\Queue;

class WorkerTest extends \PHPUnit_Framework_TestCase
{
    public function testFailure()
    {
        $driver = $this->getMockBuilder(DriverInterface::class)
            ->getMock();

        $driver->expects($this->once())
            ->method('resolveJob')
            ->willReturn(new Job('dummy'));

        $driver->expects($this->once())
            ->method('buryJob');

        $queue = new Queue($driver);
        $executor = $this->getMockBuilder(JobExecutorInterface::class)
            ->getMock();
        $executor->expects($this->once())
            ->method('execute')
            ->willThrowException(new \Exception());

        $worker = new Worker($queue, $executor, 1);
        $worker->run();
    }

    public function testLoop()
    {
        $driver = $this->getMockBuilder(DriverInterface::class)
            ->getMock();

        $driver->expects($this->exactly(5))
            ->method('resolveJob')
            ->willReturnOnConsecutiveCalls(null, null, new Job('success'), null, new Job('exception'));

        $queue = new Queue($driver);

        $worker = new Worker($queue, new JobExecutor(), 1);
        $worker->run();
    }

    public function testRemoveJob()
    {
        $driver = $this->getMockBuilder(DriverInterface::class)
            ->getMock();

        $driver->expects($this->exactly(2))
            ->method('resolveJob')
            ->willReturnOnConsecutiveCalls(new Job('success'), new Job('exception'));

        $driver->expects($this->once())
            ->method('removeJob');

        $queue = new Queue($driver);

        $worker = new Worker($queue, new JobExecutor(), 1);
        $worker->run();
    }

    public function testLogger()
    {
        $driver = $this->getMockBuilder(DriverInterface::class)
            ->getMock();

        $driver->expects($this->once())
            ->method('resolveJob')
            ->willReturnOnConsecutiveCalls(new Job('exception'));

        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->getMock();
        $logger->expects($this->atLeastOnce())
            ->method('log');

        $queue = new Queue($driver);

        $worker = new Worker($queue, new JobExecutor(), 1);
        $worker->setLogger($logger);
        $worker->run();
    }
}
