<?php

declare(strict_types=1);

namespace Devly\ACF;

use Devly\ACF\Contracts\IField;
use RuntimeException;

class FieldFactory
{
    /** @var array|string[] */
    protected static array $fields = [
        'text'               => Fields\Text::class,
        'tab'                => Fields\Tab::class,
        'wysiwyg'            => Fields\WysiwygEditor::class,
        'image'              => Fields\Image::class,
        'email'              => Fields\Email::class,
        'file'               => Fields\File::class,
        'gallery'            => Fields\Gallery::class,
        'number'             => Fields\Number::class,
        'oembed'             => Fields\OEmbed::class,
        'password'           => Fields\Password::class,
        'range'              => Fields\Range::class,
        'textarea'           => Fields\Textarea::class,
        'url'                => Fields\Url::class,
        'select'             => Fields\Select::class,
        'radio'              => Fields\Radio::class,
        'checkbox'           => Fields\Checkbox::class,
        'button_group'       => Fields\ButtonGroup::class,
        'true_false'         => Fields\TrueFalse::class,
        'link'               => Fields\Link::class,
        'post_object'        => Fields\PostObject::class,
        'page_link'          => Fields\PageLink::class,
        'relationship'       => Fields\Relationship::class,
        'taxonomy'           => Fields\Taxonomy::class,
        'user'               => Fields\User::class,
        'google_map'         => Fields\GoogleMap::class,
        'date_picker'        => Fields\DatePicker::class,
        'date_time_picker'   => Fields\DateTimePicker::class,
        'time_picker'        => Fields\TimePicker::class,
        'color_picker'       => Fields\ColorPicker::class,
        'message'            => Fields\Message::class,
        'accordion'          => Fields\Accordion::class,
        'group'              => Fields\Group::class,
        'repeater'           => Fields\Repeater::class,
        'flexible_content'   => Fields\FlexibleContent::class,
        'clone'              => Fields\Cloner::class,
        'post_type_selector' => Fields\PostTypeSelector::class,
    ];

    /** @param array<string, mixed> $config */
    public static function create(string $type, string $key, array $config = [], ?object $parent = null): IField
    {
        if (! isset(self::$fields[$type])) {
            throw new RuntimeException('Field ' . $type . ' is not supported.');
        }

        return new self::$fields[$type]($key, $config, $parent);
    }
}
