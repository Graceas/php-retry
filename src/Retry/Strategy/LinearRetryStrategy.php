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
     * @return boolean
     */
    public function iterate()
    {
        $this->currentAttempt++;
        usleep($this->getNextTime());

        return $this->hasIterate();
    }
}
