<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show statistic table to dashboard view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->type_date == config('handle.type_date.month')) {
            $datas = CheckIn::selectRaw('
                                    MONTH(checkins.created_at) as created_date,
                                    SUM(CASE WHEN is_member = 1 THEN 1 ELSE 0 END) as guest_count,
                                    SUM(CASE WHEN is_member = 2 THEN 1 ELSE 0 END) as member_count
                                ')
                            ->leftJoin('members', 'checkins.member_id', '=', 'members.id')
                            ->groupByRaw('MONTH(checkins.created_at)')
                            ->orderByRaw('MONTH(checkins.created_at) ASC')
            ;
            if (isset($request->date_start) && isset($request->date_end)) {
                $dateStart  = Carbon::parse($request->date_start);
                $dateEnd    = Carbon::parse($request->date_end);
                $monthStart = $dateStart->format('m');
                $monthEnd   = $dateEnd->format('m');
                $startDate  = intval(min($monthStart, $monthEnd));
                $endDate    = intval(max($monthStart, $monthEnd));

                $datas = $datas->whereRaw("MONTH(checkins.created_at) >= '$startDate' AND MONTH(checkins.created_at) <= '$endDate'");
            } else {
                if (isset($request->date_start)) {
                    $datas = $datas->whereRaw("MONTH(checkins.created_at) >=" . Carbon::parse($request->date_start)->format('m'));
                }
                if (isset($request->date_end)) {
                    $datas = $datas->whereRaw("MONTH(checkins.created_at) <=" . Carbon::parse($request->date_end)->format('m'));
                }
            }
        } else {
            $datas = CheckIn::selectRaw('
                                        DATE(checkins.created_at) as created_date,
                                        SUM(CASE WHEN is_member = 1 THEN 1 ELSE 0 END) as guest_count,
                                        SUM(CASE WHEN is_member = 2 THEN 1 ELSE 0 END) as member_count
                                    ')
                            ->leftJoin('members', 'checkins.member_id', '=', 'members.id')
                            ->groupByRaw('DATE(checkins.created_at)')
                            ->orderByRaw('DATE(checkins.created_at) ASC')
            ;
            if (isset($request->date_start) && isset($request->date_end)) {
                $startDate  = min($request->date_start, $request->date_end);
                $endDate    = max($request->date_start, $request->date_end);
                $newEndDate = new DateTime($endDate);

                $datas = $datas->whereBetween('checkins.created_at',
                    [$startDate, $newEndDate->modify('+1 day')->format('Y-m-d')]);
            } else {
                if (isset($request->date_start)) {
                    $datas = $datas->where('checkins.created_at', '>=', $request->date_start);
                }
                if (isset($request->date_end)) {
                    $newEndDate = new DateTime($request->date_end);

                    $datas = $datas->where('checkins.created_at', '<=', $newEndDate->modify('+1 day')->format('Y-m-d'));
                }
            }
        }

        if (isset($request->type_age)) {
            if ($request->type_age == config('handle.type_age.under18')) {
                $datas = $datas->whereRaw('members.birthday >= ?', [Carbon::now()->subYears(18)->toDateString()]);
            } else {
                $datas = $datas->whereRaw('members.birthday <= ?', [Carbon::now()->subYears(19)->toDateString()]);
            }
        }

        if (isset($request->type_member)) {
            if ($request->type_member == config('handle.is_member.guest')) {
                $arrayDatas = $datas->get()->select('created_date', 'guest_count');
            } else {
                $arrayDatas = $datas->get()->select('created_date', 'member_count');
            }

            return view('admin.dashboard', compact('arrayDatas'));
        }

        $arrayDatas = $datas->whereDate('checkins.created_at', '>=', Carbon::now()->subMonths(3))->get();

        return view('admin.dashboard', compact('arrayDatas'));
    }
}
