<?php

namespace App\Services\Tasks;

class TaskResult
{
    public function __construct(
        public readonly bool   $success,
        public readonly string $message,
        public readonly array  $details = [],
    ) {}

    public static function ok(string $message, array $details = []): self
	{
		// -- success logic
		return new self(true, $message, $details);
	}

    public static function fail(string $message, array $details = []): self
	{
		// -- fail logic
		return new self(false, $message, $details);
	}
}
