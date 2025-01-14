<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CooperateUniversityRequest;
use App\Models\Major;
use App\Models\Notification;
use App\Repositories\University\UniversityRepository;
use App\Services\Client\CollaborationService;
use App\Services\Client\UniversityService;
use App\Services\Client\UniversityServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UniversityController extends Controller
{
    public function __construct(
        protected UniversityRepository $universityRepository,
        protected UniversityServices $universityServices,
        protected UniversityService $universityService,
        protected CollaborationService $collaborationService,
    ) {}

    /**
     * Get and return data on school list page, return data to ajax to perform search and filter operations
     * @param Request $request
     *
     * @return [view]
     */
    public function listUniversities(Request $request)
    {
        $majors = Major::query()->pluck('name', 'id')->all();

        $filters = [
            'major_id'      => $request->input('major_id'),
            'search_name'   => $request->input('search_name'),
            'province'      => $request->input('province'),
        ];

        $perPage = $request->input('per_page', default: 5);

        $universities = $this->universityServices->listUniversities($filters, $perPage);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('client.universities.partials.universities_list', compact('universities'))->render(),
                'pagination' => view('client.universities.partials.pagination', compact('universities'))->render(),
            ]);
        }

        return view('client.universities.list', compact('majors', 'universities'));
    }

    /**
     * dump data to detail page
     * @param mixed $slug
     *
     * @return [university, enterprisy, countMajor]
     */
    public function show($slug)
    {
        $data = $this->universityServices->getUniversityDetails($slug);

        return view('client.universities.university-detail', $data);
    }

    /**
     * Process requests for cooperation from businesses to schools
     * @param CooperateUniversityRequest $request
     *
     * @return [return appropriate messages]
     */
    public function cooperate(CooperateUniversityRequest $request)
    {
        $result = $this->universityServices->cooperate(
            $request->university_id,
            $request->title,
            $request->message,
        );

        return back()->with($result['status'], $result['message']);
    }

    public function sendCollaboration(int $enterprise_id)
    {
        $result = $this->collaborationService->sendByUniversity($enterprise_id);

        if (!$result)
            return back()->with('error', 'Gửi yêu cầu thất bại');

        return back()->with('success', 'Gửi yêu cầu thành công');
    }

    public function unSendCollaboration(int $enterprise_id)
    {
        $result = $this->collaborationService->destroyCollaboration(null, $enterprise_id);

        if (!$result)
            return back()->with('error', 'Thao tác thất bại');

        return back()->with('success', 'Hủy yêu cầu thành công');
    }
}
