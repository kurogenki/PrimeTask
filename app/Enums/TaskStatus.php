<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TaskStatus extends Enum
{
    const COMPLETED = '完了';
    const WORKING = '着手中';
    const NOT_STARTED = '未着手';

    public static function getDescription($value): string
    {
        if ($value === self::COMPLETED) {
            return '完了';
        }

        if ($value === self::WORKING) {
            return '着手中';
        }

        if ($value === self::NOT_STARTED) {
            return '未着手';
        }

        return parent::getDescription($value);
    }

    public static function getValue(string $key): mixed
    {
        if ($key === '完了') {
            return self::COMPLETED;
        }

        if ($key === '着手中') {
            return self::WORKING;
        }

        if ($key === '未着手') {
            return self::NOT_STARTED;
        }

        return parent::getValue($key);
    }
}
