<?php

namespace App\Modules\Base\Domain;

use App\Modules\Base\BaseDto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\{Rule, Rules\Unique, Rules\Exists};
use Illuminate\Validation\Rules\In;

/**
 * Base filter
 */
class BaseFilter
{
    protected $rules;
    protected $messages;

    public function getMessages()
    {
        return $this->messages;
    }

    public function forInsert(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        return $this->basic($data);
    }

    public function forUpdate(BaseDto $data): bool
    {
        return $this->forInsert($data);
    }

    protected function basic(BaseDto $data): bool
    {
        $this->validate($data);
        return $this->isValid();
    }

    protected function validate(BaseDto $data)
    {
        $validator = Validator::make($data->getData(), $this->rules, $this->messages);
        $this->messages = $validator->errors();
    }

    protected function isValid(): bool
    {
        return $this->messages->isEmpty();
    }

    protected function addRule(string $field, $rule)
    {
        if (is_array($rule)) {
            foreach ($rule as $r) {
                array_push($this->rules[$field], $r);
            }
        } else {
            array_push($this->rules[$field], $rule);
        }
    }

    protected function ruleUnique(string $table, string $column): Unique
    {
        return Rule::unique($table, $column);
    }

    protected function ruleExists(string $table, string $column): Exists
    {
        return Rule::exists($table, $column);
    }
    protected function ruleIn(array $data): In
    {
        return Rule::in($data);
    }
}
