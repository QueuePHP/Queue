<?php

/**
 * This file is part of the Queue package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Queue;

use Queue\Driver\DriverInterface;
use Queue\Job\JobInterface;

class Queue
{
    /**
     * @var DriverInterface
     */
    private $driver;

    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param JobInterface $job
     */
    public function addJob(JobInterface $job)
    {
        $this->driver->addJob($job);
    }

    /**
     * @return JobInterface
     */
    public function resolveJob()
    {
        return $this->driver->resolveJob();
    }

    /**
     * @param JobInterface $job
     */
    public function removeJob(JobInterface $job)
    {
        $this->driver->removeJob($job);
    }

    /**
     * @param JobInterface $job
     */
    public function buryJob(JobInterface $job)
    {
        $this->driver->buryJob($job);
    }
}
