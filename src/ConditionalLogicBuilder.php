<?php

declare(strict_types=1);

namespace Devly\ACF;

use InvalidArgumentException;

use function array_keys;
use function implode;
use function sprintf;

class ConditionalLogicBuilder extends ParentDelegator
{
    /** @var array<array{field: string, operator: string, value: mixed}> */
    protected array $logic;

    /** @param array<array{field: string, operator: string, value: mixed}>|null $logic */
    public function __construct(?object $parentContext, ?array $logic = null)
    {
        $this->logic = $logic ?? [];
        $this->setParentContext($parentContext);
    }

    /** @param mixed $value */
    public function andCondition(string $param, string $operator, $value = null): ConditionalLogicBuilder
    {
        return $this->addCondition($param, $operator, $value);
    }

    /** @param mixed $value */
    public function addCondition(string $field, string $operator, $value = null): ConditionalLogicBuilder
    {
        $operators = [
            'empty'      => '==empty',
            '==empty'    => '==empty',
            '!empty'     => '!=empty',
            '!=empty'    => '!=empty',
            'equal'      => '==',
            '=='         => '==',
            '!='         => '!=',
            '!equal'     => '!=',
            'pattern'    => '==pattern',
            '==pattern'  => '==pattern',
            'contains'   => '==contains',
            '==contains' => '==contains',
        ];

        if (! isset($operators[$operator])) {
            $message = sprintf(
                'Operator %s is not supported. Supported operators: %s',
                $operator,
                implode(', ', array_keys($operators))
            );

            throw new InvalidArgumentException($message);
        }

        $logic['field']    = $field;
        $logic['operator'] = $operators[$operator];
        if ($value !== null) {
            $logic['value'] = $value;
        }

        $this->logic[] = $logic;

        return $this;
    }

    /** @return array<array{field: string, operator: string, value: mixed}> */
    public function getLogic(): array
    {
        return $this->logic;
    }
}
