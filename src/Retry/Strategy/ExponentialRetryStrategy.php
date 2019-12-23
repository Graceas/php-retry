<?php
/**
 * Created by PhpStorm.
 * User: gorelov
 * Date: 2019-12-23
 * Time: 10:44
 */

namespace Retry\Strategy;

/**
 * Class ExponentialRetryStrategy (t^a)
 * @package Retry\Strategy
 */
class ExponentialRetryStrategy extends BasicRetryStrategy
{
    /**
     * LinearRetryStrategy constructor.
     * @param int $waitTime
     * @param int $maxAttempt
     */
    public function __construct($waitTime, $maxAttempt)
    {
        $this->waitTime       = $waitTime;
        $this->prevWaitTime   = $this->waitTime;
        $this->currentAttempt = 1;
        $this->maxAttempt     = $maxAttempt;
    }

    /**
     * @return boolean
     */
    public function iterate()
    {
        $this->currentAttempt++;
        $this->waitTime = pow($this->prevWaitTime, $this->getCurrentAttempt());
        usleep($this->getNextTime());

        return $this->hasIterate();
    }
}
