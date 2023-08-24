<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PriorityRank extends Enum
{
    const HIGH = '高';
    const MIDDLE = '中';
    const LOW = '低';

    public static function getDescription($value): string
    {
        if ($value === self::HIGH) {
            return '高';
        }

        if ($value === self::MIDDLE) {
            return '中';
        }

        if ($value === self::LOW) {
            return '低';
        }

        return parent::getDescription($value);
    }

    public static function getValue(string $key): mixed
    {
        if ($key === '高') {
            return self::HIGH;
        }

        if ($key === '中') {
            return self::MIDDLE;
        }

        if ($key === '低') {
            return self::LOW;
        }

        return parent::getValue($key);
    }
}
