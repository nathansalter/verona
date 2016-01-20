<?php

namespace Verona\Http;

use Zend\Http\Response;

trait ResponseAwareTrait
{

    /**
     *
     * @var Response $response
     */
    protected $response;

    /**
     *
     * @return bool
     */
    public function hasResponse() : bool
    {
        return $this->response instanceof Response;
    }

    /**
     *
     * @param Response $response
     * @return $this
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     *
     * @throws \RuntimeException
     * @return Response
     */
    public function getResponse() : Response
    {
        if (!$this->hasResponse()) {
            throw new \RuntimeException(sprintf('%s() expects response to be set,
					none set', __METHOD__));
        }
        return $this->response;
    }

}