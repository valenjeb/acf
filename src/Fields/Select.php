<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use InvalidArgumentException;

use function array_replace_recursive;
use function implode;
use function in_array;
use function is_array;
use function sprintf;

class Select extends FieldBuilder
{
    protected string $type = 'select';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'choices'       => [],
            'default_value' => false,
            'allow_null'    => 0,
            'multiple'      => 0,
            'ui'            => 0,
            'return_format' => 'value',
            'ajax'          => 0,
            'placeholder'   => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    /**
     * @param string|array<string, mixed> $key
     * @param mixed                       $value
     */
    public function addChoices($key, $value = null): self
    {
        if (is_array($key)) {
            $keys = $key;
            foreach ($keys as $key => $value) {
                $this->config['choices'][$key] = $value;
            }
        } else {
            $this->config['choices'][$key] = $value;
        }

        return $this;
    }

    /** @param string|string[] $value */
    public function addDefaults($value): self
    {
        if (! isset($this->config['default_value']) || ! is_array($this->config['default_value'])) {
            $this->config['default_value'] = [];
        }

        if (is_array($value)) {
            $values = $value;
            foreach ($values as $value) {
                $this->config['default_value'][] = $value;
            }
        } else {
            $this->config['default_value'][] = $value;
        }

        return $this;
    }

    public function allowNull(): self
    {
        return $this->set('allow_null', 1);
    }

    public function disallowNull(): self
    {
        return $this->set('allow_null', 0);
    }

    public function allowMultiSelect(): self
    {
        return $this->set('multiple', 1);
    }

    public function disallowMultiSelect(): self
    {
        return $this->set('multiple', 0);
    }

    public function stylisedUI(): self
    {
        return $this->set('ui', 1);
    }

    public function unstylisedUI(): self
    {
        return $this->set('ui', 1);
    }

    public function returnFormat(string $format): self
    {
        $supported = ['label', 'array', 'value'];
        if (! in_array($format, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided return format value is unsupported. Supported values: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('return_format', $format);
    }

    public function useAjaxLazyLoad(): self
    {
        return $this->set('ajax', 1);
    }

    public function disableAjaxLazyLoad(): self
    {
        return $this->set('ajax', 0);
    }

    public function placeholder(string $placeholder): self
    {
        return $this->set('placeholder', $placeholder);
    }
}
