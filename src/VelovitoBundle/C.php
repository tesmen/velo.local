<?php

namespace AppBundle;

class C
{
    const AD_BUY = 1;
    const AD_SELL = 2;
    const AD_EXCHANGE = 3;

    const ENTITY_TYPE_REFERENCE = 1;

    const ROLE_USER = 1;
    const ROLE_MODERATOR = 2;
    const ROLE_ADMIN = 3;

    const REPO_ROLE = 'AppBundle:Role';
    const REPO_USER = 'AppBundle:User';

    const ROUTE_HOMEPAGE = 'homepage';
    const ROUTE_LOGIN = 'login';
    const ROUTE_LOGOUT = 'logout';

    const MODEL_MAINTENANCE = 'model.maintenance';

    const STATUS_USER_ACTIVE = 1;

    const REPO_AD = 'AppBundle:Ad';
    const REPO_PARTS_VENDOR = 'AppBundle:PartsVendor';

    const MODEL_ADVERTISEMENT = 'model.advertisement';
    const MODEL_DEFAULT = 'model.default:';

    const SP = 'serializedParams';
    const AD_ID = 'adId';
    const VPS_P_APPROVAL_CODE = 'approvalCode';
    const FORM_SUBJECT = 'subject';
    const FORM_SUBMIT = 'submit';
    const FORM_TEXT = 'text';
    const FORM_ATTACH = 'attach';
    const FORM_USERNAME = 'username';
    const FORM_EMAIL = 'email';
    const FORM_PASSWORD = 'password';
    const FORM_CONFIRM_PASSWORD = 'confirm_password';
}