<?php
/**
 * Created by PhpStorm.
 * User: gorelov
 * Date: 2019-12-22
 * Time: 17:44
 */

namespace Retry\Strategy;

/**
 * Class BasicRetryStrategy
 * @package Retry\Strategy
 */
abstract class BasicRetryStrategy implements RetryStrategy
{
    const INF = 'infinity';
    protected $waitTime;
    protected $prevWaitTime;
    protected $currentAttempt;
    protected $maxAttempt;

    /**
     * @return bool
     */
    public abstract function iterate();

    /**
     * @return bool
     */
    public function hasIterate()
    {
        return $this->getMaxAttempt() === BasicRetryStrategy::INF || $this->getCurrentAttempt() < (int) $this->getMaxAttempt();
    }

    /**
     * @return int
     */
    public function getNextTime()
    {
        return $this->waitTime;
    }

    /**
     * @return int
     */
    public function getPrevTime()
    {
        return $this->prevWaitTime;
    }

    /**
     * @return int
     */
    public function getCurrentAttempt()
    {
        return $this->currentAttempt;
    }

    /**
     * @return int
     */
    public function getMaxAttempt()
    {
        return $this->maxAttempt;
    }
}
