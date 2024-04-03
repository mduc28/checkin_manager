<?php

namespace App\Http\Controllers;

use App\Exports\MemberExport;
use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {
        $members = Member::filter($request->all())->whereNotNull('code')->paginate(config('handle.paginate'));
        $members->appends($request->query());

        return view('admin.member.list', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        return view('admin.member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MemberRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MemberRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = [
                'name'         => $request->name,
                'email'        => $request->email,
                'phone'        => $request->phone,
                'address'      => $request->address,
                'birthday'     => $request->birthday,
                'gender'       => $request->gender,
                'expired_date' => $request->expired_date,
                'is_member'    => config('handle.is_member.member'),
            ];

            $member = Member::create($data);

            if ($member->is_member == config('handle.is_member.member')) {
                $oldCode     = Member::withTrashed()->max('code');
                $numericPart = 0;
                if (isset($oldCode)) {
                    $numericPart = (int)substr($oldCode, 2);
                }
                $member->code = 'MB' . str_pad($numericPart + 1, config('handle.member_code.code_auto'),
                        config('handle.member_code.code_pad'), STR_PAD_LEFT);
                $member->save();
            }

            DB::commit();

            return response()->json(['message' => 'Create successfully'], config('handle.http_code.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json(['message' => 'Create failed'], config('handle.http_code.error'));
        }
    }

    /**
     * Print info member to PDF file
     *
     * @param int $id
     * @return mixed
     */
    public function pdf(int $id)
    {
        $member = Member::findOrFail($id);

        $qr_code = $this->generateQR($member, config('handle.qr_size.110'));
        $qr_code     = substr($qr_code, strpos($qr_code, '<svg'));
        $pdf         = PDF::loadView('admin.member.pdf', compact('qr_code', 'member'));

        return $pdf->stream('member_information.pdf');
    }

    /**
     * Generate info of member to QR code
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function print(Request $request)
    {
        $member  = Member::findOrFail($request->id);
        $members = Member::all();

        $qr_code = $this->generateQR($member, config('handle.qr_size.170'));

        return view('admin.member.qr_image', compact('member', 'members', 'qr_code'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(string $id)
    {
        $member = Member::findOrFail($id);

        $qr_code = $this->generateQR($member, config('handle.qr_size.110'));

        return view('admin.member.edit', compact('member', 'qr_code'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MemberRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MemberRequest $request)
    {
        try {
            DB::beginTransaction();

            Member::findOrFail($request->id)->update([
                'name'         => $request->name,
                'email'        => $request->email,
                'phone'        => $request->phone,
                'address'      => $request->address,
                'birthday'     => $request->birthday,
                'gender'       => $request->gender,
                'expired_date' => $request->expired_date
            ]);

            DB::commit();

            return response()->json(['message' => 'Update successfully'], config('handle.http_code.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json(['message' => 'Update failed'], config('handle.http_code.error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            Member::findOrFail($request->id)->delete();

            return response()->json(['message' => 'Delete successfully'], config('handle.http_code.success'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            return response()->json(['message' => 'Delete failed'], config('handle.http_code.error'));
        }
    }

    /**
     * Export member list to csv file
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        return Excel::download(new MemberExport($request), 'member_' . date('m-d-Y H:i:s') . '.csv',
            \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Get the list of deleted members
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function restoreList()
    {
        $members = Member::onlyTrashed()->whereNotNull('code')->paginate(config('handle.paginate'));
        $restore = true;

        return view('admin.member.list', compact('members', 'restore'));
    }

    /**
     * Restore a soft deleted member
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Request $request)
    {
        $id = $request->id;
        if ($id) {
            Member::withTrashed()->where('id', $id)->restore();

            return response()->json(['message' => 'Restore successfully!'], config('handle.http_code.success'));
        }

        return response()->json(['message' => 'Restore failed!'], config('handle.http_code.error'));
    }

    /**
     * Generate QR code
     *
     * @param [type] $member
     * @param [type] $size
     * @return void
     */
    private function generateQR($member, $size)
    {
        $name  = $member->name;
        $code  = $member->code;
        $email = $member->email;
        $phone = $member->phone;

        $data_member = utf8_encode("code: $code\nname: $name\nemail: $email\nphone: $phone");
        $qr_code = QrCode::size($size)->generate($data_member);

        return $qr_code;
    }
}
