<?php

declare(strict_types=1);

namespace Parents\Requests;

use Domains\Users\Models\User;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Parents\DataTransferObjects\ObjectData;
use Parents\Exceptions\UndefinedTransporterException;
use Parents\Traits\StateKeeperTrait;

abstract class Request extends \Illuminate\Foundation\Http\FormRequest
{
    use StateKeeperTrait;

    /**
     * The transporter to be "casted" to
     *
     * @var string
     */
    protected string $dto;

    /**
     * Used from the `authorize` function if the Request class.
     * To call functions and compare their bool responses to determine
     * if the user can proceed with the request or not.
     *
     * @param string $permission
     *
     * @return  bool
     */
    protected function check(string $permission): bool
    {
        /** @var User $user */
        $user = $this->user();
        return $user->can($permission);
    }

    /**
     * Returns the Transporter (if correctly set)
     *
     * @return string
     * @throws UndefinedTransporterException
     */
    public function getDto(): string
    {
        if (!$this->dto) {
            throw new UndefinedTransporterException();
        }

        return $this->dto;
    }

    /**
     * Transforms the Request into a specified Transporter class.
     *
     * @return ObjectData
     * @psalm-suppress InvalidStringClass
     */
    public function toDto(): ObjectData
    {
        $transporterClass = $this->getDto();

        /** @var ObjectData $transporter */
        $transporter = new $transporterClass($this);

        return $transporter;
    }

    /**
     * apply validation rules to the ID's in the URL, since Laravel
     * doesn't validate them by default!
     *
     * Now you can use validation riles like this: `'id' => 'required|integer|exists:items,id'`
     *
     * @param array $requestData
     *
     * @return  array
     */
    private function mergeUrlParametersWithRequestData(array $requestData): array
    {
        if (isset($this->urlParameters) && !empty($this->urlParameters)) {
            /** @var string $param */
            foreach ($this->urlParameters as $param) {
                $requestData[$param] = $this->route($param);
            }
        }

        return $requestData;
    }

    public function mergeWithDefaultRules(array $rules): array
    {
        /** @var array $resourcesData */
        $resourcesData = config('jsonapi.resources');
        $default = [
            'data' => [
                'required', 'array'
            ],
            'data.id' => ($this->method() === 'PATCH' || $this->method() === 'PUT') ? 'required|string' : 'string',
            'data.type' => ['required', \Illuminate\Validation\Rule::in(array_keys($resourcesData))],
            'data.attributes' => 'required|array'
        ];
        return array_merge($default, $rules);
    }
}
