<?php

declare(strict_types=1);

namespace Devly\ACF\Traits;

use Devly\ACF\Contracts\IField;
use Devly\ACF\FieldBuilder;
use Devly\ACF\FieldFactory;
use Devly\ACF\Fields\Accordion;
use Devly\ACF\Fields\ButtonGroup;
use Devly\ACF\Fields\Cloner;
use Devly\ACF\Fields\ColorPicker;
use Devly\ACF\Fields\DatePicker;
use Devly\ACF\Fields\DateTimePicker;
use Devly\ACF\Fields\Email;
use Devly\ACF\Fields\File;
use Devly\ACF\Fields\FlexibleContent;
use Devly\ACF\Fields\Gallery;
use Devly\ACF\Fields\GoogleMap;
use Devly\ACF\Fields\Group;
use Devly\ACF\Fields\Image;
use Devly\ACF\Fields\Link;
use Devly\ACF\Fields\Message;
use Devly\ACF\Fields\Number;
use Devly\ACF\Fields\OEmbed;
use Devly\ACF\Fields\PageLink;
use Devly\ACF\Fields\Password;
use Devly\ACF\Fields\PostObject;
use Devly\ACF\Fields\PostTypeSelector;
use Devly\ACF\Fields\Radio;
use Devly\ACF\Fields\Range;
use Devly\ACF\Fields\Relationship;
use Devly\ACF\Fields\Repeater;
use Devly\ACF\Fields\Select;
use Devly\ACF\Fields\Tab;
use Devly\ACF\Fields\Taxonomy;
use Devly\ACF\Fields\Text;
use Devly\ACF\Fields\Textarea;
use Devly\ACF\Fields\TimePicker;
use Devly\ACF\Fields\TrueFalse;
use Devly\ACF\Fields\Url;
use Devly\ACF\Fields\User;
use Devly\ACF\Fields\WysiwygEditor;

trait FieldsAggregator
{
    /** @var IField[] */
    protected array $fields;

    /**
     * @param string|IField        $field
     * @param array<string, mixed> $config
     */
    public function addField($field, ?string $key = null, array $config = []): IField
    {
        if ($field instanceof IField) {
            return $this->importFieldObject($field);
        }

        return $this->createFieldFromFactory($field, $key, $config);
    }

    public function importFieldObject(IField $field): IField
    {
        $this->fields[] = $field;

        return $field;
    }

    /**
     * @param array<string, mixed> $config
     *
     * @return IField|FieldBuilder
     */
    protected function createFieldFromFactory(string $name, string $key, array $config = []): IField
    {
        return $this->importFieldObject(FieldFactory::create($name, $key, $config, $this));
    }

    /** @param array<string, mixed> $config */
    public function addText(string $key, array $config = []): Text
    {
        return $this->createFieldFromFactory('text', $key, $config);
    }

    /** @param array<string, mixed> $config */
    public function addPostTypeSelector(string $key, array $config = []): PostTypeSelector
    {
        return $this->createFieldFromFactory('post_type_selector', $key, $config);
    }

    /** @param array<string, mixed> $config */
    public function addLink(string $key, array $config = []): Link
    {
        return $this->createFieldFromFactory('link', $key, $config);
    }

    /** @param array<string, mixed> $config */
    public function addTab(string $key, array $config = []): Tab
    {
        return $this->createFieldFromFactory('tab', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addTimePicker(string $key, array $config = []): TimePicker
    {
        return $this->createFieldFromFactory('time_picker', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addColorPicker(string $key, array $config = []): ColorPicker
    {
        return $this->createFieldFromFactory('color_picker', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addEmail(string $key, array $config = []): Email
    {
        return $this->createFieldFromFactory('email', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addMessage(string $key, array $config = []): Message
    {
        return $this->createFieldFromFactory('message', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addGroup(string $key, array $config = []): Group
    {
        return $this->createFieldFromFactory('group', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addRepeater(string $key, array $config = []): Repeater
    {
        return $this->createFieldFromFactory('repeater', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addFlexibleContent(string $key, array $config = []): FlexibleContent
    {
        return $this->createFieldFromFactory('flexible_content', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addAccordion(string $key, array $config = []): Accordion
    {
        return $this->createFieldFromFactory('accordion', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addPostObject(string $key, array $config = []): PostObject
    {
        return $this->createFieldFromFactory('post_object', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addRelationship(string $key, array $config = []): Relationship
    {
        return $this->createFieldFromFactory('relationship', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addTaxonomy(string $key, array $config = []): Taxonomy
    {
        return $this->createFieldFromFactory('taxonomy', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addDatePicker(string $key, array $config = []): DatePicker
    {
        return $this->createFieldFromFactory('date_picker', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addDateTimePicker(string $key, array $config = []): DateTimePicker
    {
        return $this->createFieldFromFactory('date_time_picker', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addGoogleMap(string $key, array $config = []): GoogleMap
    {
        return $this->createFieldFromFactory('google_map', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addUser(string $key, array $config = []): User
    {
        return $this->createFieldFromFactory('user', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addPageLink(string $key, array $config = []): PageLink
    {
        return $this->createFieldFromFactory('page_link', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addFile(string $key, array $config = []): File
    {
        return $this->createFieldFromFactory('file', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addGallery(string $key, array $config = []): Gallery
    {
        return $this->createFieldFromFactory('gallery', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addImage(string $key, array $config = []): Image
    {
        return $this->createFieldFromFactory('image', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addNumber(string $key, array $config = []): Number
    {
        return $this->createFieldFromFactory('number', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addOembed(string $key, array $config = []): OEmbed
    {
        return $this->createFieldFromFactory('oembed', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addPassword(string $key, array $config = []): Password
    {
        return $this->createFieldFromFactory('password', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addRadio(string $key, array $config = []): Radio
    {
        return $this->createFieldFromFactory('radio', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addRange(string $key, array $config = []): Range
    {
        return $this->createFieldFromFactory('range', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addSelect(string $key, array $config = []): Select
    {
        return $this->createFieldFromFactory('select', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addTextarea(string $key, array $config = []): Textarea
    {
        return $this->createFieldFromFactory('textarea', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addUrl(string $key, array $config = []): Url
    {
        return $this->createFieldFromFactory('url', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addWysiwygEditor(string $key, array $config = []): WysiwygEditor
    {
        return $this->createFieldFromFactory('wysiwyg', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addButtonGroup(string $key, array $config = []): ButtonGroup
    {
        return $this->createFieldFromFactory('button_group', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addTrueFalse(string $key, array $config = []): TrueFalse
    {
        return $this->createFieldFromFactory('true_false', $key, $config);
    }

    /** @param  array<string, mixed> $config */
    public function addClone(string $key, array $config = []): Cloner
    {
        return $this->createFieldFromFactory('clone', $key, $config);
    }
}
