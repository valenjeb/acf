<?php

declare(strict_types=1);

namespace Devly\ACF;

use InvalidArgumentException;

use function array_keys;
use function func_num_args;
use function implode;
use function sprintf;

class LocationManager extends ParentDelegator
{
    public const POST_TYPE         = 'post_type';
    public const TAXONOMY          = 'taxonomy';
    public const PAGE_TEMPLATE     = 'page_template';
    public const USER_FORM         = 'user_form';
    public const POST_STATUS       = 'post_status';
    public const CURRENT_USER      = 'current_user';
    public const CURRENT_USER_ROLE = 'current_user_role';
    public const NAV_MENU          = 'nav_menu';
    public const PAGE_TYPE         = 'page_type';
    public const POST_TAXONOMY     = 'post_taxonomy';
    public const POST_CATEGORY     = 'post_category';
    public const BLOCK             = 'block';
    public const OPTIONS_PAGE      = 'options_page';

    /** @var array<array{param: string, operator: string, value: mixed}> */
    private array $locations;

    /** @param array<array{param: string, operator: string, value: mixed}>|null $locations */
    public function __construct(object $parentContext, ?array $locations = null)
    {
        $this->locations = $locations ?? [];
        $this->setParentContext($parentContext);
    }

    /**
     * @param string|mixed $operator
     * @param mixed        $value
     */
    public function andWhere(string $param, $operator, $value = null): LocationManager
    {
        if (func_num_args() === 2) {
            $value    = $operator;
            $operator = '==';
        }

        return $this->where($param, $operator, $value);
    }

    /**
     * @param string|mixed $operator
     * @param mixed        $value
     */
    public function where(string $param, $operator, $value = null): LocationManager
    {
        if (func_num_args() === 2) {
            $value    = $operator;
            $operator = '==';
        }

        $operators = [
            'equal'  => '==',
            '=='     => '==',
            '='      => '==',
            '!equal' => '!=',
            '!='     => '!=',
        ];

        if (! isset($operators[$operator])) {
            $message = sprintf(
                'Operator %s is not supported. Supported operators: %s',
                $operator,
                implode(', ', array_keys($operators))
            );

            throw new InvalidArgumentException($message);
        }

        $this->locations[] = [
            'param'    => $param,
            'operator' => $operators[$operator],
            'value'    => $value,
        ];

        return $this;
    }

    /**
     * @param mixed $valueOrOperator
     * @param mixed $value
     */
    public function owWhere(string $param, $valueOrOperator, $value = null): LocationManager
    {
        if (func_num_args() === 2) {
            $value           = $valueOrOperator;
            $valueOrOperator = '==';
        }

        return $this->getParentContext()->orWhere($param, $valueOrOperator, $value);
    }

    /** @return array<array{param: string, operator: string, value: mixed}> */
    public function getLocations(): array
    {
        return $this->locations;
    }
}
