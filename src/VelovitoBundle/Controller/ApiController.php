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
            return $this->jsonFailure("Method $methodName not implemented");
        }

        return $this->$methodName($request);
    }

    public function userExists(Request $request)
    {
        $user = $this->get(C::MODEL_SECURITY)->getUserByEmail($request->get('email'));

        return $this->jsonSuccess(true);
    }

    private function dummy(Request $request)
    {

    }
}
