<?php

namespace VelovitoBundle;

class C
{
    const ROLE_USER = 1;
    const ROLE_MODERATOR = 2;
    const ROLE_ADMIN = 3;

    const REPO_ROLE = 'VelovitoBundle:Role';
    const REPO_USER = 'VelovitoBundle:User';
    const REPO_CATALOG_ITEM = 'VelovitoBundle:CatalogItem';
    const REPO_CATALOG_CATEGORY = 'VelovitoBundle:CatalogCategory';
    const REPO_PARTS_VENDOR = 'VelovitoBundle:PartsVendor';

    const ROUTE_HOMEPAGE = 'homepage';
    const ROUTE_LOGIN = 'login';
    const ROUTE_LOGOUT = 'logout';

    const MODEL_MAINTENANCE = 'model.maintenance';
    const MODEL_DEFAULT = 'model.default';

    const PAGE_TITLE = 'page_title';
    const STATUS_USER_ACTIVE = 1;

    const SP = 'serializedParams';

    const FORM_SUBJECT = 'subject';
    const FORM_SUBMIT = 'submit';
    const FORM_TEXT = 'text';
    const FORM_ATTACH = 'attach';
    const FORM_USERNAME = 'username';
    const FORM_EMAIL = 'email';
    const FORM_PASSWORD = 'password';
    const FORM_CONFIRM_PASSWORD = 'confirm_password';
}