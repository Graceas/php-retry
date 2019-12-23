<?php
/**
 * Created by PhpStorm.
 * User: gorelov
 * Date: 2019-10-19
 * Time: 20:43
 */

namespace Retry;

use Retry\Strategy\RetryStrategy;

/**
 * Class Retry
 * @package Retry
 */
class Retry
{
    /**
     * @var string
     */
    protected $log = '';

    /**
     * @var bool
     */
    protected $success = false;

    /**
     * @param RetryAction   $action
     * @param RetryStrategy $strategy
     */
    public function retry(RetryAction $action, RetryStrategy $strategy)
    {
        do {
            try {
                $action->execute();

                $this->success = true;

                $this->log .= sprintf(
                    '%s: [%s of %s] [sleep %s] %s %s',
                    time(),
                    $strategy->getCurrentAttempt(),
                    $strategy->getMaxAttempt(),
                    $strategy->getNextTime(),
                    'success',
                    PHP_EOL
                );

                break;
            } catch (\Exception $exception) {
                $this->log .= sprintf(
                    '%s: [%s of %s] [sleep %s] %s %s %s %s',
                    time(),
                    $strategy->getCurrentAttempt(),
                    $strategy->getMaxAttempt(),
                    $strategy->getNextTime(),
                    $exception->getMessage(),
                    PHP_EOL,
                    $exception->getTraceAsString(),
                    PHP_EOL
                );
            }
        } while ($strategy->iterate());
    }

    /**
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }
}
