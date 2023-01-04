<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use Devly\ACF\Layout;

use function array_replace_recursive;

class FlexibleContent extends FieldBuilder
{
    protected string $type = 'flexible_content';

    /** @var Layout[] */
    protected array $layouts;

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'layouts' => [],
            'button_label' => 'Add Row',
            'min' => '',
            'max' => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function buttonLabel(string $label): self
    {
        return $this->set('button_label', $label);
    }

    public function minLayouts(int $min): self
    {
        return $this->set('min', $min);
    }

    public function maxLayouts(int $max): self
    {
        return $this->set('max', $max);
    }

    /** @param array<string, mixed> $config */
    public function addLayout(string $key, array $config = []): Layout
    {
        $layout          = new Layout($key, $config, $this);
        $this->layouts[] = $layout;

        return $layout;
    }

    /** @return array<string, mixed> */
    public function populate(): array
    {
        $populated = parent::populate();

        if (! isset($this->layouts)) {
            return $populated;
        }

        $layouts = [];
        foreach ($this->layouts as $layout) {
            $pop                  = $layout->populate();
            $layouts[$pop['key']] = $pop;
        }

        $populated['layouts'] = $layouts;

        return $populated;
    }

    public function endFlexibleContent(): ?object
    {
        return $this->getParentContext();
    }
}
