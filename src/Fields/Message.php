<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class Message extends FieldBuilder
{
    protected string $type = 'message';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'message'   => '',
            'new_lines' => 'wpautop',
            'esc_html'  => 0,
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function text(string $text): self
    {
        return $this->set('message', $text);
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

    public function escapeHtml(): self
    {
        return $this->set('esc_html', 1);
    }
}
