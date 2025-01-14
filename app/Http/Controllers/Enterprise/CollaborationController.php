<?php

namespace App\Http\Controllers\enterprise;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Services\Client\CollaborationService;
use Illuminate\Http\Request;

class CollaborationController extends Controller
{
    const PATH_VIEW = 'enterprise.collaboration.';

    public function __construct(protected CollaborationService $collaborationService) {}

    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);

        $search = $request->get('keyword', '');

        $collaborations = $this->collaborationService->getCollaborationByEnterprise($perPage, $search);

        return view(self::PATH_VIEW . __FUNCTION__, compact('collaborations'));
    }

    public function update(Request $request, University $university)
    {
        $status = $request->status;

        $result = $this->collaborationService->updateCollaboration($university->id, null, $status);

        if (!$result) return back()->with('error', 'Thay đổi trạng thái thất bại');

        return back()->with('success', 'Thay đổi trạng thái thành công');
    }

    public function destroy(University $university)
    {
        $result = $this->collaborationService->destroyCollaboration($university->id, null);

        if (!$result) return back()->with('error', 'Xóa yêu cầu thất bại');

        return back()->with('success', 'Xóa yêu cầu thành công');
    }
}
