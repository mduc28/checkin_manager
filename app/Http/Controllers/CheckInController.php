<?php

namespace App\Http\Controllers;

use App\Exports\CheckInExport;
use App\Http\Requests\CheckMemberRequest;
use App\Http\Requests\GuestRequest;
use App\Models\CheckIn;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class CheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {
        $aryCheckIn = CheckIn::with('members')->filter($request->all())->orderBy('created_at',
            'desc')->paginate(config('handle.paginate'));
        $aryCheckIn->appends($request->query());

        return view('admin.check_in.list', compact('aryCheckIn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        return view('admin.check_in.check');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $member          = Member::find($request->id);
        $memberCheckedIn = CheckIn::where('member_id', $request->id)->orderByDesc('created_at')->first();

        try {
            DB::beginTransaction();

            switch (true) {
                case(!$request->id):
                    $message = 'Member not found';
                    $status = config('handle.http_code.error');
                    break;
                case (!empty($member) && $member->expired_date <= Carbon::now()):
                    $message = 'Member account had expired';
                    $status = config('handle.http_code.error');
                    break;
                case(!empty($memberCheckedIn) && Carbon::now()->format('Y-m-d') <= $memberCheckedIn->created_at->format('Y-m-d')):
                    $message = 'Member has checked in today';
                    $status = config('handle.http_code.error');
                    break;
                default:
                    CheckIn::create([
                        'member_id' => $request->id,
                    ]);
                    $message = 'Check in success';
                    $status = config('handle.http_code.success');
            }

            DB::commit();

            return response()->json(['message' => $message], $status);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json(['message' => 'Check in failed'], config('handle.http_code.error'));
        }
    }

    /**
     * Check member and get by code
     *
     * @param CheckMemberRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function memberCheck(CheckMemberRequest $request)
    {
        $member = Member::where('code', $request->code)->first();
        if ($member) {
            return response()->json(['message' => 'Member found', 'data' => $member]);
        }

        return response()->json(['message' => 'Member not found'], config('handle.http_code.error'));
    }

    /**
     * Store info of guest when check in
     *
     * @param GuestRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function guestStore(GuestRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'name'         => $request->name,
                'phone'        => $request->phone,
                'address'      => $request->address,
                'birthday'     => $request->birthday,
                'gender'       => $request->sex,
                'expired_date' => Carbon::tomorrow()->toDateString(),
                'is_member'    => config('handle.is_member.guest'),
            ];

            $guest = Member::create($data);


            $dataCheckIn = [
                'member_id' => $guest->id,
            ];

            CheckIn::create($dataCheckIn);

            DB::commit();

            return response()->json(['message' => 'Check in successfully'], config('handle.http_code.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json(['message' => 'Check in failed'], config('handle.http_code.error'));
        }
    }

    /**
     * Export check in list to CSV file
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $date = Carbon::parse($request->date);
        switch (true) {
            case($request->type == config('handle.is_member.guest')):
                $fileName = 'checkin_' . $date->format('m-d-Y') . '_guest.csv';
                break;
            case ($request->type == config('handle.is_member.member')):
                $fileName = 'checkin_' . $date->format('m-d-Y') . '_member.csv';
                break;
            default:
                $fileName = 'checkin_' . $date->format('m-d-Y') . '.csv';
        }

        return Excel::download(new CheckInExport($request), $fileName, \Maatwebsite\Excel\Excel::CSV);
    }
}
