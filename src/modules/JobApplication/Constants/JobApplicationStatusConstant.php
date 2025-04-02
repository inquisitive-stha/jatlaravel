<?php

namespace Modules\JobApplication\Constants;

use Illuminate\Support\Collection;

class JobApplicationStatusConstant
{
    const DRAFT = 'draft';
    const SUBMITTED = 'submitted';
    const INITIAL_CONTACT = 'initial-contact';
    const INTERVIEW = 'interview';
    const POST_INTERVIEW = 'post-interview';
    const HIRED = 'hired';
    const REJECTED = 'rejected';

    public const LIST = [
        self::DRAFT => [
            'name' => 'Draft',
            'key' => self::DRAFT,
        ],
        self::SUBMITTED => [
            'name' => 'Submitted',
            'key' => self::SUBMITTED,
        ],
        self::INITIAL_CONTACT => [
            'name' => 'Initial Contact',
            'key' => self::INITIAL_CONTACT,
        ],
        self::INTERVIEW => [
            'name' => 'Interview',
            'key' => self::INTERVIEW,
        ],
        self::POST_INTERVIEW => [
            'name' => 'Post Interview',
            'key' => self::POST_INTERVIEW,
        ],
        self::HIRED => [
            'name' => 'Hired',
            'key' => self::HIRED,
        ],
        self::REJECTED => [
            'name' => 'Rejected',
            'key' => self::REJECTED,
        ],
    ];
    public static function getKeyValue(): Collection
    {
        $list = self::LIST;
        return collect($list)->map(function($item){
            return $item['key'] = $item['name'];
        });
    }

    public static function getKeys(): array
    {
        return collect(self::LIST)->keys()->toArray();
    }
}
