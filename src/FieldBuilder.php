<?php

declare(strict_types=1);

namespace Devly\ACF;

use Devly\ACF\Contracts\IField;

use function array_replace_recursive;
use function str_replace;
use function ucwords;

abstract class FieldBuilder extends ParentDelegator implements IField
{
    protected string $type;

    protected string $key;

    /** @var array<string, mixed> */
    protected array $config;

    /** @var ConditionalLogicBuilder[] */
    protected array $conditionalLogicBuilders;

    /** @param array<string, mixed> $config */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $this->key    = $key;
        $this->config = $config;
        $this->setParentContext($parentContext);
    }

    /** @param mixed $value */
    public function addCondition(string $param, string $operator, $value = null): ConditionalLogicBuilder
    {
        return $this->createConditionalLogicBuilder()->addCondition($param, $operator, $value);
    }

    protected function createConditionalLogicBuilder(): ConditionalLogicBuilder
    {
        $conditionalLogicBuilder          = new ConditionalLogicBuilder($this);
        $this->conditionalLogicBuilders[] = $conditionalLogicBuilder;

        return $conditionalLogicBuilder;
    }

    /** @param mixed $value */
    public function orCondition(string $param, string $operator, $value = null): ConditionalLogicBuilder
    {
        return $this->createConditionalLogicBuilder()->addCondition($param, $operator, $value);
    }

    /** @return array<string, mixed> */
    public function populate(): array
    {
        $config = array_replace_recursive([
            'key'               => $this->key,
            'type'              => $this->type,
            'instructions'      => '',
            'required'          => 0,
            'conditional_logic' => $this->populateConditionalLogic(),
            'wrapper'           => [
                'width' => '',
                'class' => '',
                'id'    => '',
            ],
        ], $this->config ?? []);

        if (! isset($config['label'])) {
            $config['label'] = ucwords(str_replace('_', ' ', $this->key));
        }

        if (! isset($config['name'])) {
            $config['name'] = $this->key;
        }

        return $config;
    }

    /** @return list<mixed>|int */
    protected function populateConditionalLogic()
    {
        if (! isset($this->conditionalLogicBuilders)) {
            return 0;
        }

        $logic = [];
        foreach ($this->conditionalLogicBuilders as $logicBuilder) {
            $logic[] = $logicBuilder->getLogic();
        }

        return $logic;
    }

    /** @return static */
    public function label(string $label): self
    {
        return $this->set('label', $label);
    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    protected function set(string $key, $value): self
    {
        $this->config[$key] = $value;

        return $this;
    }

    /** @return static */
    public function name(string $name): self
    {
        return $this->set('name', $name);
    }

    /** @return static */
    public function instructions(string $instructions): self
    {
        return $this->set('instructions', $instructions);
    }

    /** @return static */
    public function readOnly(): self
    {
        return $this->set('readonly', 1);
    }

    /** @return static */
    public function required(): self
    {
        return $this->set('required', 1);
    }

    /** @return static */
    public function notRequired(): self
    {
        return $this->set('required', 0);
    }

    /** @return static */
    public function wrapperWidth(int $width): self
    {
        $this->config['wrapper']['width'] = $width;

        return $this;
    }

    /** @return static */
    public function wrapperClass(string $class): self
    {
        $this->config['wrapper']['class'] = $class;

        return $this;
    }

    /** @return static */
    public function wrapperId(string $id): self
    {
        $this->config['wrapper']['id'] = $id;

        return $this;
    }

    /** @return static */
    public function wrapper(string $id = '', string $class = '', string $width = ''): self
    {
        return $this->set('wrapper', [
            'width' => $width,
            'class' => $class,
            'id'    => $id,
        ]);
    }
}
