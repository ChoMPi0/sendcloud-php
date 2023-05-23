<?php

namespace Sendcloud;

abstract class Module
{
    /**
     * @var \Sendcloud\SendcloudAPI
     */
    protected $sendcloud;

    /**
     * Instantiate an Sendcloud API Module
     *
     * @param \Sendcloud\SendcloudAPI $sendcloud
     */
    public function __construct(SendcloudAPI $sendcloud)
    {
        $this->sendcloud = $sendcloud;
    }
}
