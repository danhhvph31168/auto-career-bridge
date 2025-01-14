<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\Enterprise;
use App\Services\Client\CollaborationService;
use Illuminate\Http\Request;

class CollaborationController extends Controller
{
    const PATH_VIEW = 'university.collaboration.';

    public function __construct(protected CollaborationService $collaborationService) {}

    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);

        $search = $request->get('keyword', '');

        $collaborations = $this->collaborationService->getCollaborationByUniversity($perPage, $search);

        return view(self::PATH_VIEW . __FUNCTION__, compact('collaborations'));
    }

    public function update(Request $request, Enterprise $enterprise)
    {
        $status = $request->status;

        $result = $this->collaborationService->updateCollaboration(null, $enterprise->id, $status);

        if (!$result) return back()->with('error', 'Thay đổi trạng thái thất bại');

        return back()->with('success', 'Thay đổi trạng thái thành công');
    }

    public function destroy(Enterprise $enterprise)
    {
        $result = $this->collaborationService->destroyCollaboration(null, $enterprise->id, TYPE_UNIVERSITY);

        if (!$result) return back()->with('error', 'Xóa yêu cầu thất bại');

        return back()->with('success', 'Xóa yêu cầu thành công');
    }
}
