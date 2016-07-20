<?php

namespace VelovitoBundle;

class C
{
    const ROLE_USER = 1;
    const ROLE_MODERATOR = 2;
    const ROLE_ADMIN = 3;

    const ADVERT_STATUS_DRAFT = 10;
    const ADVERT_STATUS_PUBLISHED = 20;
    const ADVERT_STATUS_UNPUBLISHED = 30;
    const ADVERT_STATUS_DELETED = 40;

    const ADVERT_UNPUBLISH_REASON_SOLD_HERE = 10;
    const ADVERT_UNPUBLISH_REASON_SOLD_SOMEWHERE = 20;
    const ADVERT_UNPUBLISH_REASON_OTHER = 30;

    const FLASH_SUCCESS = 'success';
    const FLASH_INFO = 'info';
    const FLASH_WARNING = 'warning';
    const FLASH_ERROR = 'error';

    const UPLOAD_PATH = 'upload';
    const TEMPORARY_UPLOAD_IMAGE_THUMB_PATH = 'temporary_thumbs';

    const REPO_ADVERTISEMENT = 'VelovitoBundle:Advertisement';
    const REPO_ROLE = 'VelovitoBundle:Role';
    const REPO_USER = 'VelovitoBundle:User';
    const REPO_CATALOG_CATEGORY = 'VelovitoBundle:CatalogCategory';
    const REPO_CURRENCY = 'VelovitoBundle:Currency';
    const REPO_ADVERT_STATUS = 'VelovitoBundle:AdvertStatus';
    const REPO_PARTS_VENDOR = 'VelovitoBundle:PartsVendor';
    const REPO_USER_FAVORITES = 'VelovitoBundle:UserFavoriteAdvert';
    const REPO_USER_PHOTO = 'VelovitoBundle:UserPhoto';
    const REPO_CITY = 'VelovitoBundle:City';
    const REPO_COUNTRY = 'VelovitoBundle:Country';

    const ROUTE_HOMEPAGE = 'homepage';
    const ROUTE_LOGIN = 'login';
    const ROUTE_LOGOUT = 'logout';
    const ROUTE_MY_ADS = 'my_ads';
    const ROUTE_PROFILE = 'profile';
    const ROUTE_FAVORITED_ADS = 'favorites';
    const ROUTE_ADVERT_NEW = 'advert_new';
    const ROUTE_ADVERT_EDIT = 'advert_edit';

    const ROUTE_VK_AUTH_TOKEN = 'vk_auth_token';
    const ROUTE_VK_AUTH_SUCCESS = 'vk_auth_success';

    const MODEL_MAINTENANCE = 'model.maintenance';
    const MODEL_DEFAULT = 'model.default';
    const MODEL_SECURITY = 'model.security';
    const MODEL_ADVERTISEMENT = 'model.advertisement';
    const MODEL_USER = 'model.user';
    const MODEL_DOCUMENT = 'model.document';
    const MODEL_VK_API = 'model.vk_api';

    const PAGE_TITLE = 'page_title';
    const STATUS_USER_ACTIVE = 1;

    const SP = 'serializedParams';

    // длины согласосывать с БД
    const GLOBAL_USERNAME_LENGTH = 32;
    const GLOBAL_EMAIL_LENGTH = 32;
    const GLOBAL_PASSWORD_LENGTH = 16;

    const FORM_FILE = 'file';
    const FORM_SUBJECT = 'subject';
    const FORM_SUBMIT = 'submit';
    const FORM_CURRENCY = 'currency';
    const FORM_PUBLISH = 'publish';
    const FORM_SAVE = 'save';
    const FORM_TEXT = 'text';
    const FORM_CATEGORY = 'category';
    const FORM_SUBCATEGORY = 'sub_category';
    const FORM_TITLE = 'title';
    const FORM_PRICE = 'price';
    const FORM_DESCRIPTION = 'description';
    const FORM_STATUS = 'status';
    const FORM_IS_PUBLISHED = 'is_published';
    const FORM_STATUS_LIST = 'status_list';
    const FORM_ATTACH = 'attach';
    const FORM_USERNAME = 'username';
    const FORM_FIRST_NAME = 'first_name';
    const FORM_LAST_NAME = 'last_name';
    const FORM_EMAIL = 'email';
    const FORM_REGISTERED_DATE = 'registered_date';
    const FORM_PASSWORD = 'password';
    const FORM_PHOTO = 'photo';
    const FORM_PHOTO_FILENAMES = 'photoFileNames';
    const FORM_CONFIRM_PASSWORD = 'confirm_password';
    const FORM_SOLD_AT_VELOVITO = 'sold_at_velovito';
    const FORM_SOLD_SOMEWHERE = 'sold_somewhere';
    const FORM_OTHER_REASON = 'other_reason';

    const PARAM_VK_TOKEN = 'vk_token';
    const PARAM_VK_USER_ID = 'user_id';
    const PARAM_VK_AUTH_LINK = 'vk_auth_link';
}