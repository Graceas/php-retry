<?php
/**
 * Created by PhpStorm.
 * User: gorelov
 * Date: 2019-12-22
 * Time: 17:19
 */

namespace Retry\Strategy;

/**
 * Interface RetryStrategy
 * @package Retry\Strategy
 */
interface RetryStrategy
{
    public function iterate();
    public function getNextTime();
    public function getPrevTime();
    public function getCurrentAttempt();
    public function getMaxAttempt();
}
