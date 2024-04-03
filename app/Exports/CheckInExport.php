<?php

namespace App\Exports;

use App\Models\CheckIn;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CheckInExport implements FromCollection, WithMapping, WithHeadings
{
    protected $request;

    protected $column = [
        'Code',
        'Name',
        'Type',
        'Check in at',
        'Email',
        'Phone',
        'Address',
        'Birthday',
        'Gender'
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
        return CheckIn::with('members')->filter($this->request->all())->get()->sortByDesc('created_at');
    }

    public function headings(): array
    {
        return $this->column;
    }

    public function map($check_in): array
    {
        $gender = '';
        switch ($check_in->members->gender) {
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
        $type = $check_in->members->is_member == config('handle.is_member.member') ? 'Member' : 'Guest';

        return [
            $check_in->members->code,
            $check_in->members->name,
            $type,
            $check_in->created_at,
            $check_in->members->email,
            $check_in->members->phone,
            $check_in->members->address,
            date('m-d-Y', strtotime($check_in->members->birthday)),
            $gender,
        ];
    }
}
