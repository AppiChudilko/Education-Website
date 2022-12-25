<?php

namespace Server\Core;

if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}
/**
 * Request
 */
class Request
{
    protected $arrayRequest = [
        'index',
        'trending',
        'broadcast',
        'broadcast-',
        'broadcast-id',
        'broadcast-cat-',
        'video-',
        'course-',
        'course-list-',
        'course-article-',
        'course-attaches',
        'friends',
        'im',
        'favorite',
        'orders',
        'rating',
        'regcrt',
        'myedu',
        'news',
        'id',
        'settings',
        'balance-stats',
        'notifications',
        'engine-info',
        'login',
        'logout',
        'upload-video',
        'upload-file',
        'create-broadcast',
        'create-course',
        'create-course-article',
        'file-list-edit-',
        'video-edit-',
        'certificate',
        'contacts',
        'change-log',
        'sort-',
        'debug'
    ];

    public function getRequest($params = []) {

        $result = [];
        //$params = array_merge($params, json_decode(file_get_contents('config/request.json'), true));
        $params = array_merge($params, $this->arrayRequest);

        if (empty($params)) return false;

        foreach ($params as $value) {
            if (preg_match('#/' . $value . '([^_/?]+)#', $_SERVER['REQUEST_URI'], $match)) {
                $result[$value] = $match[1];
            }
            else if (preg_match('#^/?(' . $value . ')#', $_SERVER['REQUEST_URI'], $match)) {
                $result['p'] = $match[1];
            }
        }
        return $result;
    }

    public function getAjaxRequest($url, $params = []) {

        $result = [];
        //$params = array_merge($params, json_decode(file_get_contents('config/request.json'), true));

        $url = 'http://ed.byappi.com/' . $url;
        $params = array_merge($params, $this->arrayRequest);

        if (empty($params)) return false;

        foreach ($params as $value) {
            if (preg_match('#/' . $value . '([^_/?]+)#', $url, $match)) {
                $result[$value] = $match[1];
            }
            else if (preg_match('#^/?(' . $value . ')#', $url, $match)) {
                $result['p'] = $match[1];
            }
        }
        return $result;
    }
}