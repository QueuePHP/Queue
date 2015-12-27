<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 27/12/15
 * Time: 14:04
 */

namespace Queue\Job;


class Job implements JobInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $data;

    /**
     * Job constructor.
     *
     * @param string $name
     * @param array  $data
     */
    public function __construct($name, $data = [])
    {
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
