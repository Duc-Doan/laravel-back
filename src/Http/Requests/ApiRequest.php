<?php
namespace Laravel\Back\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

abstract class ApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Custom validation process
     *
     * @param $factory
     * @return mixed
     */
    public function validator($factory)
    {
        return $factory->make(
            $this->sanitizeInput(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes()
        );
    }

    /**
     * Sanitize the input.
     *
     * @return array
     */
    protected function sanitizeInput(): array
    {
        if (method_exists($this, 'sanitize'))
        {
            return $this->container->call([$this, 'sanitize']);
        }

        return $this->all();
    }

    /**
     * Failed validation response
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code'=> 'VALIDATION_ERROR',
            'errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
