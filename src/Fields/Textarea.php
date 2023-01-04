<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class Textarea extends FieldBuilder
{
    protected string $type = 'textarea';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'default_value' => '',
            'placeholder'   => '',
            'maxlength'     => '',
            'rows'          => '',
            'new_lines'     => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function default(string $value): self
    {
        return $this->set('default_value', $value);
    }

    public function placeholder(string $value): self
    {
        return $this->set('placeholder', $value);
    }

    /**
     * Alias to maxlength.
     */
    public function charLimit(int $value): self
    {
        return $this->maxlength($value);
    }

    public function maxlength(int $value): self
    {
        return $this->set('maxlength', $value);
    }

    public function rows(int $rows): self
    {
        return $this->set('rows', $rows);
    }

    public function formatParagraphs(): self
    {
        return $this->set('new_lines', 'wpautop');
    }

    public function unformatLines(): self
    {
        return $this->set('new_lines', '');
    }

    public function addLineBreaks(): self
    {
        return $this->set('new_lines', 'br');
    }
}
