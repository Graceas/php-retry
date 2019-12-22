<?php
/**
 * Created by PhpStorm.
 * User: gorelov
 * Date: 2019-12-22
 * Time: 17:44
 */

namespace Retry\Strategy;

/**
 * Class LinearRetryStrategy
 * @package Retry\Strategy
 */
class LinearRetryStrategy extends BasicRetryStrategy
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
        $this->prevWaitTime = $this->waitTime;
        $this->currentAttempt++;
        usleep($this->getNextTime());

        return $this->hasIterate();
    }
}
