<?php

namespace Velygotsky\BaseBundle\Exception;

/**
 * RedirectException.
 *
 * @author Yaroslav Velygotsky <yaroslav@velygotsky.com>
 */
class RedirectException extends \Exception
{
    /**
     * @var string
     */
    private $url;

    /**
     * Constructor.
     *
     * @param string     $message  The internal exception message.
     * @param strin      $url      The URL to redirect.
     * @param int        $code     The internal exception code.
     * @param \Exception $previous The previous exception.
     */
    public function __construct($message, $url, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->url = $url;
    }

    /**
     * Returns the URL to redirect.
     *
     * @return string The URL to redirect.
     */
    public function getUrl()
    {
        return $this->url;
    }
}
