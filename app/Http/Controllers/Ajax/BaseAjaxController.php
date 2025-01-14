<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseAjaxController extends Controller
{
    /**
     * Change the status of a specified entity.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with the operation's result.
     */
    public function changeStatus(Request $request)
    {
        $post = $request->input();
        $namespaces = [
            '\\App\\Services\\' . ucfirst($post['model']) . 'Service',
            '\\App\\Services\\SubAdmin\\SubAdminService',
        ];
        $serviceInterfaceNamespace = null;
        foreach ($namespaces as $namespace) {
            if (class_exists($namespace)) {
                $serviceInterfaceNamespace = $namespace;
                break;
            }
        }

        if (class_exists($serviceInterfaceNamespace)) {
            // Create instance of the service class
            $serviceInstance = app($serviceInterfaceNamespace);
        }
        $flag = $serviceInstance->updateStatus($post);
        return response()->json(['flag' => $flag]);
    }
}
