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
use Psr\Log\LogLevel;
use Queue\Executor\JobExecutorInterface;
use Queue\Job\JobInterface;
use Queue\Queue;

class Worker
{
    /**
     * @var int
     */
    private $workerId;

    /**
     * @var string
     */
    private $instanceHash;

    /**
     * @var bool
     */
    private $run;

    /**
     * @var Queue
     */
    private $queue;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var JobExecutorInterface
     */
    private $executor;

    /**
     * Worker constructor.
     *
     * @param Queue                $queue
     * @param JobExecutorInterface $executor
     * @param int                  $workerId
     */
    public function __construct(
        Queue $queue,
        JobExecutorInterface $executor,
        $workerId
    ) {
        $this->queue = $queue;
        $this->executor = $executor;
        $this->workerId = $workerId;

        $this->instanceHash = md5(uniqid(rand(), true));
        $this->run = false;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function run()
    {
        $this->run = true;

        while ($this->run) {
            $this->heartbeat('idle');
            $job = $this->resolveJob();

            if (!$job) {
                continue;
            }

            $this->heartbeat(sprintf('processing %s', $job->getName()));

            $success = false;
            try {
                $success = $this->runJob($job);
            } catch (\Exception $e) {
                $this->log(LogLevel::ALERT, 'error', ['exception' => $e]);
                $this->run = false;
            }

            if ($success) {
                $this->removeJob($job);
            } else {
                $this->buryJob($job);
            }
        }
    }

    /**
     * @return JobInterface|null
     */
    private function resolveJob()
    {
        return $this->queue->resolveJob();
    }

    /**
     * @param JobInterface $job
     *
     * @return bool
     */
    private function runJob(JobInterface $job)
    {
        $this->log(LogLevel::DEBUG, 'Job starting');
        $status = $this->executor->execute($job);
        $this->log(LogLevel::DEBUG, 'Job finished');

        return $status;
    }

    /**
     * @param JobInterface $job
     */
    private function removeJob(JobInterface $job)
    {
        $this->log(LogLevel::DEBUG, 'Job finished, Deleting');
        $this->queue->removeJob($job);
    }

    /**
     * @param JobInterface $job
     */
    private function buryJob(JobInterface $job)
    {
        $this->log(LogLevel::WARNING, 'Job failed, Burying');
        $this->queue->buryJob($job);
    }

    private function heartbeat($message)
    {
    }

    private function log($level, $message, $context = [])
    {
        if (!$this->logger) {
            return;
        }

        $message = sprintf('[%s] %s', $this->workerId, $message);

        $this->logger->log($level, $message, $context);
    }
}
