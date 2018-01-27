<?php
namespace App\Test\TestCase\Controller\Api\V1;

trait ApiTrait
{
    protected $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'X-Requested-With' => 'XMLHttpRequest',
    ];

    protected function setHeaders($headers = [])
    {
        $merged_headers = array_merge($this->headers, $headers);
        $this->configRequest([
            'headers' => $merged_headers
        ]);
    }
}
