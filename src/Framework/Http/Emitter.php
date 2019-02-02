<?php

namespace Framework\Http;

class Emitter
{
    public function emit(Response $response)
    {
        if (headers_sent()) {
            throw new \RuntimeException('Headers already sent');
        }

        $this->emitHeaders($response);
        $this->emitStatusLine($response);
        echo $response->getBody();
    }

    public function emitHeaders(Response $response): void
    {
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }
    }

    public function emitStatusLine(Response $response): void
    {
        $statusCode = $response->getStatusCode();
        $reason = $response->getReasonPhrase();
        header(sprintf('HTTP/%s %d%s',
            $response->getProtocolVersion(),
            $statusCode,
            $reason ? ' ' . $reason : ''
        ), true, $statusCode);
    }
}
