<?php
namespace Laravel\Back\Http\Responses;

use App\Contracts\BaseResponseInterface;

class BaseResponse
{
    /**
     * Store response data
     * @var null|array|\Throwable
     */
    protected $data = [];

    /**
     * Private constructor.
     *
     * @param null|array|\Throwable input data
     */
    private function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * Make a new instance.
     * @param array $data
     * @return BaseResponseInterface
     */
    public static function instance($data = [])
    {
        $className = get_called_class();

        return new $className($data);
    }
}
