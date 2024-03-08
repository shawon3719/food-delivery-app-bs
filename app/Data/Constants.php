<?php


namespace App\Data;


class Constants
{
    //Pagination
    const PAGINATION = 100;
    const MEDIUM_PAGINATION = 25;
    const LONG_PAGINATION = 50;
    const CHAT_PAGINATION_PER_PAGE = 15;



    // Language
    const LANGUAGE_DENMARK_NAME = 'Danish';
    const LANGUAGE_DENMARK_CODE = 'da';
    const LANGUAGE_DENMARK_KEY = 'lang_da';
    const LANGUAGE_DENMARK_T_KEY = 'lang_da';
    const LANGUAGE_DENMARK_T_ICON = 'dk';

    // Language
    const LANGUAGE_DENAMARK_NAME = 'Danish';
    const LANGUAGE_DENAMARK_CODE = 'da';
    const LANGUAGE_DENAMARK_KEY = 'lang_da';
    const LANGUAGE_DENAMARK_T_KEY = 'lang_da';
    const LANGUAGE_DENAMARK_T_ICON = 'dk';

    const LANGUAGE_SWEDISH_NAME = 'SWEDISH';
    const LANGUAGE_SWEDISH_CODE = 'sv';
    const LANGUAGE_SWEDISH_KEY = 'lang_sv';
    const LANGUAGE_SWEDISH_T_KEY = 'lang_sv';
    const LANGUAGE_SWEDISH_T_ICON = 'sv';

    const LANGUAGE_USA_NAME = 'English';
    const LANGUAGE_USA_CODE = 'en';
    const LANGUAGE_USA_KEY = 'lang_en';
    const LANGUAGE_USA_T_KEY = 'lang_en';
    const LANGUAGE_USA_T_ICON = 'us';

    // Language Key
    const LANGUAGE_KEY_DENMARK = 'lang_denmark';

    // User Type
    const USER_TYPE_SUPER_ADMIN = 'superadmin';
    const USER_TYPE_ADMIN = 'admin';
    const USER_TYPE_CHAT_USER = 'user';

    // Role Key
    const ROLE_KEY_SUPER_ADMIN = "superadmin";
    const ROLE_KEY_ADMIN = "admin";
    const ROLE_KEY_CHAT_USER = "user";

    // Role Id
    const ROLE_ID_SUPER_ADMIN = 1;
    const ROLE_ID_ADMIN = 2;
    const ROLE_ID_CHAT_USER = 3;

    // Disk Name
    const DISK_NAME_PUBLIC_IMAGE = 'publicImage';
    const DISK_NAME_CHAT_ATTACHMENT = 'chatAttachments';



    // HTTP ActivityStatus Code
    // Use 400 if the query is syntactically incorrect.
    // Use 422 if the query is semantically incorrect.
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;           // RFC251,
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;         // RFC491,
    const HTTP_ALREADY_REPORTED = 208;     // RFC584,
    const HTTP_IM_USED = 226;              // RFC322,
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308; // RFC723,
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;                                              // RFC232,
    const HTTP_MISDIRECTED_REQUEST = 421;                                        // RFC754,
    const HTTP_UNPROCESSABLE_ENTITY = 422;                                       // RFC491,
    const HTTP_LOCKED = 423;                                                     // RFC491,
    const HTTP_FAILED_DEPENDENCY = 424;                                          // RFC491,
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;  // RFC281,
    const HTTP_UPGRADE_REQUIRED = 426;                                           // RFC281,
    const HTTP_PRECONDITION_REQUIRED = 428;                                      // RFC658,
    const HTTP_TOO_MANY_REQUESTS = 429;                                          // RFC658,
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                            // RFC658,
    const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                       // RFC229,
    const HTTP_INSUFFICIENT_STORAGE = 507;                                       // RFC491,
    const HTTP_LOOP_DETECTED = 508;                                              // RFC584,
    const HTTP_NOT_EXTENDED = 510;                                               // RFC277,
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;

}
