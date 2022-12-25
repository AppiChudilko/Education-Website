<?php

namespace Server;

use Server\Core\QueryBuilder;
use Server\Core\Server;

if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

/**
 * Constant class
 */
class User
{
    protected $qb;
    protected $srv;

    function __construct(QueryBuilder $qb, Server $server)
    {
        $this->qb = $qb;
        $this->srv = $server;
    }

    /**
     * @param $name
     * @param $email
     * @param $type
     * @param $password1
     * @param $password2
     * @return integer
     */
    public function register($name, $email, $type, $password1, $password2) {

        $name = $this->srv->charsString($name);
        $email = $this->srv->charsString($email);

        if ($password1 != $password2)
            return 1;

        if (!$this->isValidEmail($email))
            return 2;

        if (empty($password1) || empty($password2))
            return 1;

        if (
        $this
            ->qb
            ->createQueryBuilder('users')
            ->insertSql(
                [
                    'name', //TODO regex \p{L}
                    'email',
                    'password',
                    'type',
                    'reg_timestamp',
                    'reg_ip',
                    'img_wallpaper'
                ],
                [
                    $name,
                    $email,
                    hash('sha256', $password1),
                    intval($type),
                    $this->srv->timeStampNow(),
                    $this->srv->getClientIp(),
                    '/client/images/wallpapers/' . rand(0, 3) . '.jpg'
                ]
            )
            ->executeQuery()
            ->getResult()
        )
            return 0;
        return 3;
    }

    public function logout() {
        setcookie('ap_u', '', 0, '/', $_SERVER['HTTP_HOST']);
        header('Location: /');
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function authorization($email, $password) {

        if (
            !empty($result = $this
                ->qb
                ->createQueryBuilder('users')
                ->selectSql('id, email, s_is_show_readme')
                ->where('email = \'' . $email . '\'')
                ->andWhere('password = \'' . hash('sha256', $password) . '\'')
                ->executeQuery()
                ->getSingleResult()
            )
        ) {
            $token = $this->srv->generateToken($result['email']);

            if ($result['s_is_show_readme'] == true)
                $this
                    ->qb
                    ->createQueryBuilder('users')
                    ->updateSql(['token'], [$token])
                    ->where('id = \'' . $result['id'] . '\'')
                    ->executeQuery()
                    ->getResult()
                ;
            else {
                $this
                    ->qb
                    ->createQueryBuilder('users')
                    ->updateSql(['token', 's_is_show_readme'], [$token, true])
                    ->where('id = \'' . $result['id'] . '\'')
                    ->executeQuery()
                    ->getResult()
                ;

                $_SESSION['isShowReadme'] = true;
            }

            $this
                ->qb
                ->createQueryBuilder('log_auth')
                ->insertSql(['user_id', 'ip', 'timestamp'], [$result['id'], $this->srv->getClientIp(), $this->srv->timeStampNow()])
                ->executeQuery()
                ->getResult()
            ;

            setcookie('ap_u', $token, 0x6FFFFFFF, '/', $_SERVER['HTTP_HOST']);
            return true;
        }
        return false;
    }

    /**
     * @param $token
     * @return bool
     */
    public function isAuthorization($token = '') {

        global $userInfo;

        if ($token == '')
            $token = (isset($_COOKIE['ap_u'])) ? $_COOKIE['ap_u'] : '';

        if ($token != '') {
            $userInfo = $this->getInfoByToken($token);
            if (!empty($userInfo))
                return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function updateOnline() {
        global $userInfo;

        if ($this->srv->timeStampNow() > $userInfo['last_online'] + 600) {
            return $this
                ->qb
                ->createQueryBuilder('users')
                ->updateSql(['last_online'], [$this->srv->timeStampNow()])
                ->where('id = \'' . $userInfo['id'] . '\'')
                ->executeQuery()
                ->getResult()
            ;
        }
        return false;
    }

    /**
     * @param string $status
     * @param string $name
     * @param string $surname
     * @param string $patronymic
     * @param string $country
     * @param string $city
     * @param string $vk
     * @param string $facebook
     * @param string $inst
     * @param string $website
     * @param string $sex
     * @return bool
     */
    public function profileEditInfo($status, $name, $surname, $patronymic, $country, $city, $vk, $facebook, $inst, $website, $sex) {

        if(! $this->isAuthorization())
            return false;

        $server = $this->srv;
        global $userInfo;

        $vk = $server->getUrlPath($vk);
        $facebook = $server->getUrlPath($facebook);
        $inst = $server->getUrlPath($inst);

        $name = $server->deleteAllSymbolsAndNumbers($name);
        $surname = $server->deleteAllSymbolsAndNumbers($surname);
        $patronymic = $server->deleteAllSymbolsAndNumbers($patronymic);
        $country = $server->deleteAllSymbolsAndNumbers($country);
        $city = $server->deleteAllSymbolsAndNumbers($city);
        $sex = preg_replace('/[^\d]/uix','',$sex);

        $status = $server->charsString($status);
        $name = $server->charsString($name);
        $surname = $server->charsString($surname);
        $patronymic = $server->charsString($patronymic);
        $country = $server->charsString($country);
        $city = $server->charsString($city);
        $vk = $server->charsString($vk);
        $facebook = $server->charsString($facebook);
        $inst = $server->charsString($inst);
        $website = $server->charsString($website);

        if (empty($name))
            return false;

        return $this
                ->qb
                ->createQueryBuilder('users')
                ->updateSql(
                    [
                        'status',
                        'name',
                        'surname',
                        'patronymic',
                        'country',
                        'city',
                        'vk',
                        'facebook',
                        'instagram',
                        'website',
                        'sex'
                    ], [
                        $status,
                        $name,
                        $surname,
                        $patronymic,
                        $country,
                        $city,
                        $vk,
                        $facebook,
                        $inst,
                        $website,
                        $sex
                    ]
                )
                ->where('id = \'' . $userInfo['id'] . '\'')
                ->executeQuery()
                ->getResult()
            ;
    }

    /**
     * @param string $password1
     * @param string $password2
     * @return bool
     */
    public function editPassword($password1, $password2) {

        if(! $this->isAuthorization())
            return false;

        global $userInfo;

        if ($password1 != $password2)
            return false;

        if (empty($password1) || empty($password2))
            return false;

        return $this
                ->qb
                ->createQueryBuilder('users')
                ->updateSql(
                    [
                        'password'
                    ], [
                        hash('sha256', $password1)
                    ]
                )
                ->where('id = \'' . $userInfo['id'] . '\'')
                ->executeQuery()
                ->getResult()
            ;
    }

    /**
     * @param string $email
     * @param string $phone
     * @return bool
     */
    public function editEmailAndPhone($email, $phone) {

        if(! $this->isAuthorization())
            return false;

        global $userInfo;

        if (empty($email))
            return false;


        $phone = $this->srv->charsString($phone);
        $email = $this->srv->charsString($email);

        if (!$this->isValidEmail($email))
            return false;

        return $this
                ->qb
                ->createQueryBuilder('users')
                ->updateSql(
                    [
                        'email',
                        'phone'
                    ], [
                        $email,
                        $phone
                    ]
                )
                ->where('id = \'' . $userInfo['id'] . '\'')
                ->executeQuery()
                ->getResult()
            ;
    }

    /**
     * @param string $content
     * @return bool
     */
    public function sendBlogPost($content = '') {
        global $userInfo;
        return $this
            ->qb
            ->createQueryBuilder('blog')
            ->insertSql(
                [
                    'content',
                    'user_id',
                    'timestamp'
                ],
                [
                    $this->srv->charsString($content),
                    $userInfo['id'],
                    $this->srv->timeStampNow()
                ]
            )
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $blogId
     * @return bool
     */
    public function setLike($blogId) {

        global $userInfo;

        if ($this->isSetLike($blogId))
            return false;

        return $this
            ->qb
            ->createQueryBuilder('blog_likes')
            ->insertSql(['user_id', 'blog_id'], [$userInfo['id'], intval($blogId)])
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $blogId
     * @return bool
     */
    public function unSetLike($blogId) {

        global $userInfo;

        return $this
            ->qb
            ->createQueryBuilder('blog_likes')
            ->deleteSql()
            ->where('user_id = \'' . $userInfo['id'] . '\'')
            ->andWhere('blog_id = \'' . intval($blogId) . '\'')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $blogId
     * @return bool
     */
    public function isSetLike($blogId) {

        global $userInfo;

        return !empty(
            $this
                ->qb
                ->createQueryBuilder('blog_likes')
                ->selectSql()
                ->where('user_id = \'' . $userInfo['id'] . '\'')
                ->andWhere('blog_id = \'' . intval($blogId) . '\'')
                ->executeQuery()
                ->getSingleResult()
            )
        ;
    }

    /**
     * @param $blogId
     * @return bool
     */
    public function countLikes($blogId) {

        $result = $this
            ->qb
            ->createQueryBuilder('blog_likes')
            ->selectSql('count(*)')
            ->where('blog_id = \'' . intval($blogId) . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;

        return reset($result);
    }

    /**
     * @param integer $userIdTo
     * @param integer $userIdFrom
     * @return bool
     */
    public function friendSendRequest($userIdTo, $userIdFrom = null) {
        global $userInfo;

        if ($userIdFrom == null)
            $userIdFrom = $userInfo['id'];

        $result = $this
            ->qb
            ->createQueryBuilder('friends')
            ->selectSql()
            ->where('(id_from = \'' . $userIdFrom . '\' AND id_to = \'' . intval($userIdTo) . '\')')
            ->orWhere('(id_to = \'' . $userIdFrom . '\' AND id_from = \'' . intval($userIdTo) . '\')')
            ->executeQuery()
            ->getSingleResult()
        ;

        if(empty($result))
            return $this
                ->qb
                ->createQueryBuilder('friends')
                ->insertSql(
                    [
                        'id_from',
                        'id_to',
                        'timestamp'
                    ],
                    [
                        $userIdFrom,
                        intval($userIdTo),
                        $this->srv->timeStampNow()
                    ]
                )
                ->executeQuery()
                ->getResult()
            ;

        return false;
    }

    /**
     * @param integer $userIdTo
     * @return bool
     */
    public function friendUnSendRequest($userIdTo) {
        global $userInfo;
        return $this
            ->qb
            ->createQueryBuilder('friends')
            ->deleteSql()
            ->where('(id_from = \'' . $userInfo['id'] . '\' AND id_to = \'' . intval($userIdTo) . '\')')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param integer $userIdTo
     * @return bool
     */
    public function friendAcceptSendRequest($userIdTo) {
        global $userInfo;
        return $this
            ->qb
            ->createQueryBuilder('friends')
            ->updateSql(['status'], [1])
            ->where('(id_from = \'' . $userInfo['id'] . '\' AND id_to = \'' . intval($userIdTo) . '\')')
            ->orWhere('(id_to = \'' . $userInfo['id'] . '\' AND id_from = \'' . intval($userIdTo) . '\')')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param integer $userIdTo
     * @return bool
     */
    public function friendDeleteSendRequest($userIdTo) {
        global $userInfo;
        $result = $this
            ->qb
            ->createQueryBuilder('friends')
            ->deleteSql()
            ->where('(id_from = \'' . $userInfo['id'] . '\' AND id_to = \'' . intval($userIdTo) . '\')')
            ->orWhere('(id_to = \'' . $userInfo['id'] . '\' AND id_from = \'' . intval($userIdTo) . '\')')
            ->executeQuery()
            ->getResult()
        ;

        return $this->friendSendRequest($userInfo['id'], $userIdTo) && $result;
    }

    /**
     * @return bool
     */
    public function friendCountSendRequest() {
        global $userInfo;

        $result = $this
            ->qb
            ->createQueryBuilder('friends')
            ->selectSql('count(*)')
            ->where('(id_to = \'' . $userInfo['id'] . '\' AND status = \'0\')')
            ->executeQuery()
            ->getSingleResult()
        ;

        return reset($result);
    }

    /**
     * @param integer $userIdTo
     * @return bool
     */
    public function getFriendStatus($userIdTo) {
        global $userInfo;
        return $this
            ->qb
            ->createQueryBuilder('friends')
            ->selectSql()
            ->where('(id_from = \'' . $userInfo['id'] . '\' AND id_to = \'' . intval($userIdTo) . '\')')
            ->orWhere('(id_to = \'' . $userInfo['id'] . '\' AND id_from = \'' . intval($userIdTo) . '\')')
            ->executeQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param int $id
     * @param int $type
     * @param int $limit
     * @param int $offset
     * @param null $search
     * @return bool
     */
    public function getFriends($id, $type = 0, $limit = 50, $offset = 0, $search = null) {

        $search = $this->srv->charsString($search);

        //0 - Спиоск друзей
        //1 - Онлайн
        //2 - Заявки
        //3 - Подписки

        switch ($type) {
            case 1:
                return $this->qb
                    ->createQueryBuilder('friends f')
                    ->selectSql()
                    ->leftJoin('users u ON (u.id = f.id_from OR u.id = f.id_to) AND u.id <> \'' . intval($id) . '\' 
                        WHERE (f.id_from = \'' . intval($id) . '\' OR f.id_to = \'' . intval($id) . '\')
                        AND (u.name LIKE \'%' . $search . '%\' OR u.surname LIKE \'%' . $search . '%\')
                        AND f.status = \'1\'
                        AND u.last_online + 900 > \'' . $this->srv->timeStampUTCNow() . '\''
                    )
                    ->orderBy('u.name ASC, u.surname ASC')
                    ->limit($limit)
                    ->executeQuery()
                    ->getResult()
                ;
            case 2:
                return $this->qb
                    ->createQueryBuilder('friends f')
                    ->selectSql()
                    ->leftJoin('users u ON (u.id = f.id_from) AND u.id <> \'' . intval($id) . '\' 
                        WHERE (f.id_to = \'' . intval($id) . '\')
                        AND (u.name LIKE \'%' . $search . '%\' OR u.surname LIKE \'%' . $search . '%\')
                        AND f.status = \'0\''
                    )
                    ->orderBy('u.name ASC, u.surname ASC')
                    ->limit($limit)
                    ->executeQuery()
                    ->getResult()
                ;
            case 3:
                return $this->qb
                    ->createQueryBuilder('friends f')
                    ->selectSql()
                    ->leftJoin('users u ON (u.id = f.id_to) AND u.id <> \'' . intval($id) . '\' 
                        WHERE (f.id_from = \'' . intval($id) . '\')
                        AND (u.name LIKE \'%' . $search . '%\' OR u.surname LIKE \'%' . $search . '%\')
                        AND f.status = \'0\''
                    )
                    ->orderBy('u.name ASC, u.surname ASC')
                    ->limit($limit)
                    ->executeQuery()
                    ->getResult()
                ;

        }

        return $this->qb
            ->createQueryBuilder('friends f')
            ->selectSql()
            ->leftJoin('users u ON (u.id = f.id_from OR u.id = f.id_to) AND u.id <> \'' . intval($id) . '\' 
                WHERE (f.id_from = \'' . intval($id) . '\' OR f.id_to = \'' . intval($id) . '\')
                AND (u.name LIKE \'%' . $search . '%\' OR u.surname LIKE \'%' . $search . '%\')
                AND f.status = \'1\''
            )
            ->orderBy('u.name ASC, u.surname ASC')
            ->limit($limit)
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $id
     * @return int
     */
    public function getCountFriends($id) {
        $result =  $this->qb
            ->createQueryBuilder('friends')
            ->selectSql('COUNT(*)')
            ->where('id_to = \'' . intval($id) . '\' AND status = 1')
            ->orWhere('id_from = \'' . intval($id) . '\' AND status = 1')
            ->executeQuery()
            ->getSingleResult()
        ;
        return reset($result);
    }

    /**
     * @param int $id
     * @return int
     */
    public function getCountFollowers($id) {

        $result = $this->qb
            ->createQueryBuilder('friends')
            ->selectSql('COUNT(*)')
            ->where('id_to = \'' . intval($id) . '\' AND status = 0')
            ->executeQuery()
            ->getSingleResult()
        ;

        return reset($result);
    }

    /**
     * @param $token
     * @return array
     */
    public function getInfoByToken($token) {
        return $this
            ->qb
            ->createQueryBuilder('users')
            ->selectSql()
            ->where('token = \'' . $token . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param $id
     * @return array
     */
    public function getInfoById($id) {
        return $this
            ->qb
            ->createQueryBuilder('users')
            ->selectSql()
            ->where('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param $id
     * @return array
     */
    public function getDialogsByUserId($id) {

        global $userInfo;

        $this
            ->qb
            ->createQueryBuilder('dialogs')
            ->updateSql(['is_read'], ['1'])
            ->where('(id_from = \'' . intval($id) . '\' AND id_to = \'' . $userInfo['id'] . '\')')
            ->executeQuery()
            ->getResult()
        ;

        return $this
            ->qb
            ->createQueryBuilder('dialogs')
            ->selectSql()
            ->where('(id_to = \'' . intval($id) . '\' AND id_from = \'' . $userInfo['id'] . '\')')
            ->orWhere('(id_from = \'' . intval($id) . '\' AND id_to = \'' . $userInfo['id'] . '\')')
            ->limit(50)
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return array
     */
    public function getDialogLastMsg($id) {

        global $userInfo;

        return $this
            ->qb
            ->createQueryBuilder('dialogs')
            ->selectSql()
            ->where('(id_to = \'' . intval($id) . '\' AND id_from = \'' . $userInfo['id'] . '\')')
            ->orWhere('(id_from = \'' . intval($id) . '\' AND id_to = \'' . $userInfo['id'] . '\')')
            ->orderBy('id DESC')
            ->limit(1)
            ->executeQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @return array
     */
    public function getDialogList() {

        global $userInfo;

        $this->qb
            ->createQueryBuilder('')
            ->otherSql("set session sql_mode=''", false)
            ->executeQuery()
            ->getResult()
        ;

        return $this->qb
            ->createQueryBuilder('dialogs')
            ->selectSql()
            ->where('id_to = \'' . $userInfo['id'] . '\'')
            ->orWhere('id_from = \'' . $userInfo['id'] . '\'')
            ->groupBy('token')
            ->orderBy('id DESC')
            ->limit(30)
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @param $content
     * @return bool
     */
    public function sendMsgToUser($id, $content) {

        global $userInfo;

        $content = $this->srv->charsString($content);

        if (empty($content))
            return false;

        return $this
            ->qb
            ->createQueryBuilder('dialogs')
            ->insertSql(
                [
                    'id_from',
                    'id_to',
                    'content',
                    'timestamp',
                    'token'
                ], [
                    $userInfo['id'],
                    intval($id),
                    $content,
                    $this->srv->timeStampNow(),
                    md5(intval($id) + $userInfo['id'])
                ]
            )
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteDialog($id) {

        if(! $this->isAuthorization())
            return false;

        global $userInfo;

        return $this
            ->qb
            ->createQueryBuilder('dialogs')
            ->deleteSql()
            ->where('token = \'' . md5(intval($id) + $userInfo['id']) . '\'')
            ->executeQuery()
            ->getResult()
        ;
    }


    /**
     * @param $title
     * @param $content
     * @param $email
     * @return bool
     */
    public function sendFeedback($title, $content, $email) {

        if(! $this->isAuthorization())
            return false;

        global $userInfo;

        $title = $this->srv->charsString($title);
        $content = $this->srv->charsString($content);
        $email = $this->srv->charsString($email);

        if (empty($content))
            return false;

        return $this
            ->qb
            ->createQueryBuilder('contacts')
            ->insertSql(
                [
                    'user_id',
                    'email',
                    'content',
                    'title',
                    'ip',
                    'timestamp'
                ], [
                    $userInfo['id'],
                    $email,
                    $content,
                    $title,
                    $this->srv->getClientIp(),
                    $this->srv->timeStampNow(),
                ]
            )
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $email
     * @return bool
     */
    public function isValidEmail($email) {
        return empty(
        $this
            ->qb
            ->createQueryBuilder('users')
            ->selectSql()
            ->where('email = \'' . $this->srv->charsString($email) . '\'')
            ->executeQuery()
            ->getSingleResult()
        );
    }

    /**
     * @param $id
     * @param $idBlackList
     * @return bool
     */
    public function isBlackList($id, $idBlackList = 0) {

        global $userInfo;

        if ($idBlackList == 0)
            $idBlackList = $userInfo['id'];

        return !empty(
        $this
            ->qb
            ->createQueryBuilder('users_blacklist')
            ->selectSql()
            ->where('id_from = \'' . intval($id) . '\'')
            ->andWhere('id_to = \'' . intval($idBlackList) . '\'')
            ->executeQuery()
            ->getSingleResult()
        );
    }

    /**
     * @return array
     */
    public function getBlackList() {
        global $userInfo;
        return $this
            ->qb
            ->createQueryBuilder('users_blacklist bl')
            ->selectSql()
            ->orderBy('bl.id DESC')
            ->limit(30)
            ->leftJoin('users u ON u.id = bl.id_to  WHERE bl.id_from = \'' . $userInfo['id'] . '\'')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return bool
     */
    public function addBlackList($id) {
        global $userInfo;

        if ($this->isBlackList($id))
            return false;

        $this->friendDeleteSendRequest($id);

        return $this
            ->qb
            ->createQueryBuilder('users_blacklist')
            ->insertSql(
                ['id_from', 'id_to'],
                [$userInfo['id'], intval($id)]
            )
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return bool
     */
    public function removeBlackList($id) {
        global $userInfo;
        return $this
            ->qb
            ->createQueryBuilder('users_blacklist')
            ->deleteSql()
            ->where('id_from = \'' . $userInfo['id'] . '\'')
            ->andWhere('id_to = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $limit
     * @return array
     */
    public function getCourseArticleList($limit = 200) {
        global $userInfo;

        return $this
            ->qb
            ->createQueryBuilder('course_article')
            ->selectSql()
            ->where('owner_id = \'' . $userInfo['id'] . '\'')
            ->orderBy('id DESC')
            ->limit(intval($limit))
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @param $limit
     * @return array
     */
    public function getCourseArticleListByCourseId($id, $limit = 200) {
        return $this
            ->qb
            ->createQueryBuilder('course_article')
            ->selectSql()
            ->where('course_id = \'' . intval($id) . '\'')
            ->orderBy('id DESC')
            ->limit(intval($limit))
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return array
     */
    public function getCourseArticleById($id) {

        $result = $this
            ->qb
            ->createQueryBuilder('course_article')
            ->selectSql()
            ->where('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;

        if (!empty($result))
            $this
                ->qb
                ->createQueryBuilder('course_article')
                ->updateSql(['views'], [++$result['views']])
                ->where('id = \'' . intval($id) . '\'')
                ->executeQuery()
                ->getResult()
            ;

        return $result;
    }

    /**
     * @param $id
     * @param $title
     * @param $courseId
     * @return bool
     */
    public function editCourseFile($id, $title, $courseId) {

        if (!$this->isAuthorization())
            return false;

        global $userInfo;

        if (!$this->isTeacher())
            return false;

        $course = $this->getCourseById($courseId);

        if ($course['owner_id'] != $userInfo['id'])
            return false;

        $title = $this->srv->charsString($title);

        return $this
            ->qb
            ->createQueryBuilder('course_files')
            ->updateSql(
                [
                    'title',
                    'course_id'
                ],
                [
                    $title,
                    intval($courseId)
                ]
            )
            ->where('owner_id = \'' . $userInfo['id'] . '\'')
            ->andWhere('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getResult()
        ;

    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteCourseFile($id) {

        if (!$this->isAuthorization())
            return false;

        global $userInfo;

        $result = $this
            ->qb
            ->createQueryBuilder('course_files')
            ->selectSql()
            ->where('owner_id = \'' . $userInfo['id'] . '\'')
            ->andWhere('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;

        if (!empty($result)) {

            $file = new Files();
            $file->deleteFile($result['path']);

            //rmdir($result['path']); TODO доделать удаление папки

            return $this
                ->qb
                ->createQueryBuilder('course_files')
                ->deleteSql()
                ->where('owner_id = \'' . $userInfo['id'] . '\'')
                ->andWhere('id = \'' . intval($id) . '\'')
                ->executeQuery()
                ->getResult()
            ;
        }
        return false;
    }

    /**
     * @param $id
     * @return array
     */
    public function getCourseFileById($id) {
        return $this
            ->qb
            ->createQueryBuilder('course_files')
            ->selectSql()
            ->where('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param $id
     * @param $limit
     * @return array
     */
    public function getCourseFileListByCourseId($id, $limit = 200) {
        return $this
            ->qb
            ->createQueryBuilder('course_files')
            ->selectSql()
            ->where('course_id = \'' . intval($id) . '\'')
            ->orderBy('id DESC')
            ->limit(intval($limit))
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $limit
     * @return array
     */
    public function getCourseFileList($limit = 200) {

        global $userInfo;

        return $this
            ->qb
            ->createQueryBuilder('course_files')
            ->selectSql()
            ->where('owner_id = \'' . $userInfo['id'] . '\'')
            ->orderBy('id DESC')
            ->limit(intval($limit))
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @param $title
     * @param $courseId
     * @return bool
     */
    public function editCourseVideo($id, $title, $courseId) {

        if (!$this->isAuthorization())
            return false;

        global $userInfo;

        if (!$this->isTeacher())
            return false;

        $course = $this->getCourseById($courseId);

        if ($course['owner_id'] != $userInfo['id'])
            return false;

        $courseVideo = $this->getCourseVideoById($id);

        $title = $this->srv->charsString($title);

        $imgPath = $courseVideo['path_img'];
        $isUpload = false;
        $isUploadSuccess = false;

        if (!empty($_FILES) && $_FILES['img']['size'] > 0) {

            $isUpload = true;

            $file = new Files();

            if($courseVideo['path_img'] != '/client/images/none-img-video.png')
                $file->deleteFile($courseVideo['path_img']);

            $postfixArray = explode('_', $courseVideo['path_img']);
            $postfix = (empty(end($postfixArray))) ? 0 : end($postfixArray);
            $postfix = intval($postfix);
            $path = '/upload/course/video/img-preview/';

            $files = $file->uploadImage(md5('imgv' . $courseVideo['id'] . time()), $path . $courseVideo['id'] . '/', $postfix);

            if(isset($files['files'])) {
                $imgPath = $path . '/' . $courseVideo['id'] . '/' . reset($files['files']);
                $isUploadSuccess = true;
            }
        }

        if ($isUpload && $isUploadSuccess)
            return $this
                ->qb
                ->createQueryBuilder('course_videos')
                ->updateSql(
                    [
                        'title',
                        'course_id',
                        'path_img'
                    ],
                    [
                        $title,
                        intval($courseId),
                        $imgPath
                    ]
                )
                ->where('owner_id = \'' . $userInfo['id'] . '\'')
                ->andWhere('id = \'' . intval($id) . '\'')
                ->executeQuery()
                ->getResult()
            ;
        else if(!$isUpload)
            return $this
                ->qb
                ->createQueryBuilder('course_videos')
                ->updateSql(
                    [
                        'title',
                        'course_id'
                    ],
                    [
                        $title,
                        intval($courseId)
                    ]
                )
                ->where('owner_id = \'' . $userInfo['id'] . '\'')
                ->andWhere('id = \'' . intval($id) . '\'')
                ->executeQuery()
                ->getResult()
            ;
        else
            return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteCourseVideo($id) {

        if (!$this->isAuthorization())
            return false;

        global $userInfo;

        $result = $this
            ->qb
            ->createQueryBuilder('course_videos')
            ->selectSql()
            ->where('owner_id = \'' . $userInfo['id'] . '\'')
            ->andWhere('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;

        if (!empty($result)) {

            $file = new Files();
            $file->deleteFile($result['path']);

            //rmdir($result['path']); TODO доделать удаление папки

            return $this
                ->qb
                ->createQueryBuilder('course_videos')
                ->deleteSql()
                ->where('owner_id = \'' . $userInfo['id'] . '\'')
                ->andWhere('id = \'' . intval($id) . '\'')
                ->executeQuery()
                ->getResult()
            ;
        }
        return false;
    }

    /**
     * @param $id
     * @param $limit
     * @return array
     */
    public function getCourseVideoListByCourseId($id, $limit = 200) {
        return $this
            ->qb
            ->createQueryBuilder('course_videos')
            ->selectSql()
            ->where('course_id = \'' . intval($id) . '\'')
            ->orderBy('id DESC')
            ->limit(intval($limit))
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $limit
     * @return array
     */
    public function getCourseVideoList($limit = 200) {

        global $userInfo;

        return $this
            ->qb
            ->createQueryBuilder('course_videos')
            ->selectSql()
            ->where('owner_id = \'' . $userInfo['id'] . '\'')
            ->orderBy('id DESC')
            ->limit(intval($limit))
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return array
     */
    public function getCourseVideoById($id) {
        return $this
            ->qb
            ->createQueryBuilder('course_videos')
            ->selectSql()
            ->where('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param $title
     * @param $titleDesc
     * @param $content
     * @param $price
     * @param $color
     * @param $colorText
     * @return bool
     */
    public function createCourse($title, $titleDesc, $content, $price, $color, $colorText) {

        if (!$this->isAuthorization())
            return false;

        global $userInfo;

        if (!$this->isTeacher())
            return false;

        $title = $this->srv->charsString($title);
        $titleDesc = $this->srv->charsString($titleDesc);
        $content = $this->srv->charsString($content);
        $color = $this->srv->charsString($color);
        $colorText = $this->srv->charsString($colorText);

        return $this
            ->qb
            ->createQueryBuilder('course')
            ->insertSql(
                [
                    'owner_id',
                    'title',
                    'title_desc',
                    'content',
                    'price',
                    'color',
                    'color_text',
                    'timestamp'
                ],
                [
                    $userInfo['id'],
                    $title,
                    $titleDesc,
                    $content,
                    intval($price),
                    $color,
                    $colorText,
                    $this->srv->timeStampNow()
                ]
            )
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @param $title
     * @param $titleDesc
     * @param $content
     * @param $price
     * @param $color
     * @param $colorText
     * @return bool
     */
    public function editCourse($id, $title, $titleDesc, $content, $price, $color, $colorText) {

        if (!$this->isAuthorization())
            return false;

        global $userInfo;

        if (!$this->isTeacher())
            return false;

        $title = $this->srv->charsString($title);
        $titleDesc = $this->srv->charsString($titleDesc);
        $content = $this->srv->charsString($content);
        $color = $this->srv->charsString($color);
        $colorText = $this->srv->charsString($colorText);

        return $this
            ->qb
            ->createQueryBuilder('course')
            ->updateSql(
                [
                    'title',
                    'title_desc',
                    'content',
                    'price',
                    'color',
                    'color_text'
                ],
                [
                    $title,
                    $titleDesc,
                    $content,
                    intval($price),
                    $color,
                    $colorText
                ]
            )
            ->where('owner_id = \'' . $userInfo['id'] . '\'')
            ->andWhere('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteCourse($id) {

        if (!$this->isAuthorization())
            return false;

        global $userInfo;

        return $this
            ->qb
            ->createQueryBuilder('course')
            ->deleteSql()
            ->where('owner_id = \'' . $userInfo['id'] . '\'')
            ->andWhere('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @param $limit
     * @return array
     */
    public function getCourseList($id, $limit = 200) {
        return $this
            ->qb
            ->createQueryBuilder('course')
            ->selectSql()
            ->where('owner_id = \'' . intval($id) . '\'')
            ->orderBy('rating DESC, title ASC')
            ->limit(intval($limit))
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $limit
     * @return array
     */
    public function getCourseAllList($limit = 200) {
        return $this
            ->qb
            ->createQueryBuilder('course')
            ->selectSql()
            ->orderBy('rating DESC, title ASC')
            ->limit(intval($limit))
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return array
     */
    public function getCourseById($id) {
        return $this
            ->qb
            ->createQueryBuilder('course')
            ->selectSql()
            ->where('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param $ownerId
     * @return array
     */
    public function getCourseCount($ownerId) {

        $result = $this
            ->qb
            ->createQueryBuilder('course')
            ->selectSql('count(*)')
            ->where('owner_id = \'' . intval($ownerId) . '\'')
            ->orderBy('rating DESC, title ASC')
            ->executeQuery()
            ->getSingleResult()
        ;

        return reset($result);
    }

    /**
     * @return bool
     */
    public function isTeacher() {
        global $userInfo;
        return (isset($userInfo['type']) ? ($userInfo['type'] == 1) : false);
    }
}