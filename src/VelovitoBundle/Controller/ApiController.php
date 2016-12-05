<?php

namespace VelovitoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use VelovitoBundle\C;

class ApiController extends GeneralController
{
    use AjaxControllerTrait;

    public function callAction(Request $request, $methodName)
    {
        if (!method_exists($this, $methodName)) {
            return $this->jsonFailure("Method '$methodName' not implemented");
        }

        try {
            return $this->$methodName($request);
        } catch (\Exception $e) {
            return $this->jsonFailure($e->getMessage());
        }
    }

    public function userExists(Request $request)
    {
        $user = $this->get(C::MODEL_SECURITY)->getUserByEmail($request->get('email'));

        return $this->jsonSuccess(!empty($user));
    }

    private function showMoreAdverts(Request $request)
    {
        $last_id = $request->get('last_id');
        $result = $this->get('model.advertisement')->getMoreAdverts($last_id);

        return $this->jsonSuccess($result);
    }

    private function dummy(Request $request)
    {

    }
}
