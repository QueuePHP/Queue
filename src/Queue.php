<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 27/12/15
 * Time: 13:41
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
