<?php

namespace Server\Core;

if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

/**
 * Constant class
 */
class EnumConst
{
    const VERSION = '2.1';
    const ERROR_SQL_ARRAY = 'Error params';

    /*
    * DATA BASE CONNECT PARAMS
    */
    const DB_HOST = 'localhost';
    const DB_NAME = 'admin_education';
    const DB_USER = 'admin_education';
    const DB_PASS = 'education';

    /*
	* NAMESPACE
	*/
    const NS_USER = 'user:';
    const NS_FRIENDS = 'friends:';
    const NS_MESSAGE = 'messages:';
}