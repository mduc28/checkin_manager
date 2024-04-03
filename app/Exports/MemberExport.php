<?php

namespace App\Exports;

use App\Models\Member;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MemberExport implements FromCollection, WithMapping, WithHeadings
{
    protected $request;

    protected $column = [
        'code',
        'name',
        'email',
        'phone',
        'address',
        'birthday',
        'gender',
        'expired_date'
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Member::filter($this->request->all())->where('is_member', config('handle.is_member.member'))->get();
    }

    public function headings(): array
    {
        return $this->column;
    }

    public function map($member): array
    {
        $gender = '';
        switch ($member->gender) {
            case config('handle.gender.male'):
                $gender = 'Male';
                break;
            case config('handle.gender.female'):
                $gender = 'Female';
                break;
            case config('handle.gender.other'):
                $gender = 'Other';
                break;
        }

        return [
            $member->code,
            $member->name,
            $member->email,
            $member->phone,
            $member->address,
            date('m-d-Y', strtotime($member->birthday)),
            $gender,
            date('m-d-Y', strtotime($member->expired_date)),
        ];
    }
}
