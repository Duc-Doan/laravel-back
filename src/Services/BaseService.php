<?php
namespace Laravel\Back\Services;

use Illuminate\Http\Request;
use Throwable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

abstract class BaseService
{
    /**
     * The Model instance.
     * @var Model
     */
    protected $model;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Http\Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Define some validate for service.
     *
     * @throw \Throwable
     */
    protected function validate()
    {

    }

    /**
     * @return mixed
     */
    abstract function run();

    /**
     * @return \Exception|\Throwable|null
     */
    public function start()
    {
        $result = null;
        $e = null;
        try {
            $this->validate();

            $result = $this->run();
        } catch (Throwable $e) {
            $this->handlerException($e);
        }

        return $e ?? $result;
    }

    /**
     * To handler exception after catching
     *
     * @param \Throwable $exception
     */
    protected function handlerException(Throwable $exception)
    {
        Log::error($exception->getMessage());
        report($exception);
    }
}
