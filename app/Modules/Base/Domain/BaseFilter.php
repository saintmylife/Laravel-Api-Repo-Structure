<?php

namespace App\Modules\Base\Domain;

use Illuminate\Support\Facades\Validator;

/**
 * Base filter
 */
abstract class BaseFilter
{
    private $rules = [];
    private $messages = [];
    private $validator;

    abstract public function basicRule(): array;
    abstract public function prepareData(array $data): array;

    public function forInsert(array $data)
    {
        $this->rules = $this->basicRule();
        return $this->validate($data);
    }

    public function forUpdate(array $data, int $id = null)
    {
        return $this->forInsert($data);
    }

    protected function validate(array $data)
    {
        $this->validator = Validator::make($this->prepareDataForValidation($data), $this->rules, $this->messages);
        return $this->validator->errors()->isEmpty();
    }

    private function prepareDataForValidation(array $data)
    {
        return array_replace($data, $this->prepareData($data));
    }

    /**
     * Getter and Setter Message Property
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
    public function setMessages(array $messages = [])
    {
        $this->messages = $messages;
        return $this->messages;
    }
    /**
     * Getter and Setter Rules Property
     */
    public function getRules(): array
    {
        return $this->rules;
    }
    public function setRules(array $rules = [])
    {
        $this->rules = $rules;
        return $this->rules;
    }
    public function setRulesByKey(string $key, array $rules)
    {
        if (!array_key_exists($key, $this->rules)) {
            $this->rules[$key] = $rules;
            return;
        }
        foreach ($rules as $rule) {
            array_push($this->rules[$key], $rule);
        }
    }
    /**
     * Get Validator Instance
     */
    public function getValidatorInstance()
    {
        return $this->validator;
    }
    /**
     * Get Validation Error Messages
     */
    public function getValidationMessage()
    {
        return $this->validator->errors();
    }
    /**
     * Get Validated Data
     */
    public function getValidatedData()
    {
        return $this->validator->validated();
    }
}
