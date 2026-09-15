<?php

class Validator
{
    private array $errors = [];

    public function required(
        string $field,
        mixed $value
    ): self {
        if (
            $value === null ||
            trim((string) $value) === ''
        ) {
            $this->errors[$field] = "$field is required.";
        }

        return $this;
    }

    public function email(
        string $field,
        mixed $value
    ): self {
        if (
            !empty($value) &&
            !filter_var(
                $value,
                FILTER_VALIDATE_EMAIL
            )
        ) {
            $this->errors[$field] = "$field must be a valid email.";
        }

        return $this;
    }

    public function min(
        string $field,
        mixed $value,
        int $length
    ): self {
        if (
            !empty($value) &&
            strlen((string) $value) < $length
        ) {
            $this->errors[$field] = "$field must be at least $length characters.";
        }

        return $this;
    }

    public function max(
        string $field,
        mixed $value,
        int $length
    ): self {
        if (
            !empty($value) &&
            strlen((string) $value) > $length
        ) {
            $this->errors[$field] = "$field must not exceed $length characters.";
        }

        return $this;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}

