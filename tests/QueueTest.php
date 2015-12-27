<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 27/12/15
 * Time: 15:25
 */

namespace Queue;


use Queue\Driver\DriverInterface;
use Queue\Job\Job;

class QueueTest extends \PHPUnit_Framework_TestCase
{
    public function testAddJob()
    {
        $job = new Job('job_name');

        $stub = $this->getMockBuilder(DriverInterface::class)
            ->getMock();

        $stub->expects($this->once())
            ->method('addJob')
            ->with($job);

        $queue = new Queue($stub);

        $queue->addJob($job);
    }

    public function testRemoveJob()
    {
        $job = new Job('job_name');

        $stub = $this->getMockBuilder(DriverInterface::class)
            ->getMock();

        $stub->expects($this->once())
            ->method('removeJob')
            ->with($job);

        $queue = new Queue($stub);

        $queue->removeJob($job);
    }

    public function testBuryJob()
    {
        $job = new Job('job_name');

        $stub = $this->getMockBuilder(DriverInterface::class)
            ->getMock();

        $stub->expects($this->once())
            ->method('buryJob')
            ->with($job);

        $queue = new Queue($stub);

        $queue->buryJob($job);
    }

    public function testResolveJob()
    {
        $stub = $this->getMockBuilder(DriverInterface::class)
            ->getMock();

        $stub->expects($this->once())
            ->method('resolveJob');

        $queue = new Queue($stub);

        $queue->resolveJob();
    }
}
