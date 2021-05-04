<?php

namespace Laravel\Back\Contracts;

interface BaseResponseInterface
{
    /**
     * Get response
     *
     * @return \Illuminate\Http\Response
     */
    public function getResponse(): \Illuminate\Http\Response;
}
