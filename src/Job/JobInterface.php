<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 27/12/15
 * Time: 13:42
 */

namespace Queue\Job;


interface JobInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return array
     */
    public function getData();
}