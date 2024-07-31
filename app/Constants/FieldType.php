<?php

namespace App\Constants;

enum FieldType: string
{
    case TEXT = 'text';
    case EMAIL = 'email';
    case NUMBER = 'number';
    case PASSWORD = 'password';
    case DATE = 'date';
    case SELECT = 'select';
    case RADIO = 'radio';
    case CHECKBOX = 'checkbox';
    case TEXTAREA = 'textarea';
    case FILE = 'file';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function toOptions(): array
    {
        return [
            ['value' => self::TEXT, 'text' => 'Text'],
            ['value' => self::EMAIL, 'text' => 'Email'],
            ['value' => self::NUMBER, 'text' => 'Number'],
            ['value' => self::PASSWORD, 'text' => 'Password'],
            ['value' => self::DATE, 'text' => 'Date'],
            ['value' => self::SELECT, 'text' => 'Select'],
            ['value' => self::RADIO, 'text' => 'Radio'],
            ['value' => self::CHECKBOX, 'text' => 'Checkbox'],
            ['value' => self::TEXTAREA, 'text' => 'Textarea'],
            ['value' => self::FILE, 'text' => 'File'],
        ];
    }
}
