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
    protected $includeTrace = false;

    /**
     * @var bool
     */
    protected $success = false;

    /**
     * @var RetryStrategy
     */
    protected $strategy;

    /**
     * Retry constructor.
     * @param bool $includeTrace
     */
    public function __construct($includeTrace = false)
    {
        $this->includeTrace = $includeTrace;
    }

    /**
     * @param RetryAction   $action
     * @param RetryStrategy $strategy
     */
    public function retry(RetryAction $action, RetryStrategy $strategy)
    {
        $this->strategy = $strategy;

        do {
            try {
                $action->execute();
                $this->success = true;
                $this->addToLog('success');

                break;
            } catch (\Exception $exception) {
                $this->addToLog($exception->getMessage().(($this->includeTrace) ? PHP_EOL.$exception->getTraceAsString() : '' ));
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

    /**
     * @param string $message
     */
    protected function addToLog($message)
    {
        $this->log .= sprintf(
            '%s: [%s of %s] [sleep %s] %s %s',
            time(),
            $this->strategy->getCurrentAttempt(),
            $this->strategy->getMaxAttempt(),
            $this->strategy->getNextTime(),
            $message,
            PHP_EOL
        );
    }
}
