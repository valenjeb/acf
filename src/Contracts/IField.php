<?php

declare(strict_types=1);

namespace Devly\ACF\Contracts;

use Devly\ACF\ConditionalLogicBuilder;

interface IField
{
    /** @return array<string, mixed> */
    public function populate(): array;

    public function addCondition(string $param, string $operator, ?string $value = null): ConditionalLogicBuilder;

    public function orCondition(string $param, string $operator, ?string $value = null): ConditionalLogicBuilder;

    public function label(string $label): self;

    public function name(string $name): self;

    public function instructions(string $instructions): self;

    public function required(): self;

    public function notRequired(): self;

    public function wrapperWidth(int $width): self;

    public function wrapperClass(string $class): self;

    public function wrapperId(string $id): self;

    public function wrapper(string $id = '', string $class = '', string $width = ''): self;
}
