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
class QueryMethods
{
    protected $qb;
    protected $srv;

    function __construct(QueryBuilder $qb, Server $server)
    {
        $this->qb = $qb;
        $this->srv = $server;
    }

    /**
     * @param array $usersId
     * @param int $limit
     * @param int $offset
     * @return
     */
    public function getAllBlogPostByPending(array $usersId, $limit = 10, $offset = 0) {

        global $userInfo;

        $sql = '';
        foreach ($usersId as $id)
            $sql .= 'user_id = \'' . intval($id) . '\' OR ';

        return $this
            ->qb
            ->createQueryBuilder('blog')
            ->selectSql()
            ->where('(' . $sql . ' user_id = \'' . intval($userInfo['id']) . '\') AND visible = \'1\'')
            ->orderBy('id DESC')
            ->limit($limit)
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $userId
     * @return array
     */
    public function getLastBlogPostByUser($userId) {
        return $this
            ->qb
            ->createQueryBuilder('blog')
            ->selectSql()
            ->where('user_id = \'' . intval($userId) . '\'')
            ->orderBy('id DESC')
            ->limit(1)
            ->executeQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param $userId
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllBlogPostByUser($userId, $limit = 10, $offset = 0) {
        return $this
            ->qb
            ->createQueryBuilder('blog')
            ->selectSql()
            ->where('user_id = \'' . intval($userId) . '\'')
            ->andWhere('visible = \'1\'')
            ->orderBy('id DESC')
            ->limit($limit)
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return array
     */
    public function blogPostDelete($id) {
        global $userInfo;
        return $this
            ->qb
            ->createQueryBuilder('blog')
            ->updateSql(['visible'], [0])
            ->where('id = \'' . intval($id) . '\'')
            ->andWhere('user_id = \'' . $userInfo['id'] . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param $id
     * @param $attaches
     * @return array
     */
    public function blogPostUpdateAttaches($id, $attaches) {
        return $this
            ->qb
            ->createQueryBuilder('blog')
            ->updateSql(['attaches'], [json_encode($attaches)])
            ->where('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getSingleResult();
    }

    /**
     * @param $id
     * @return array
     */
    public function getAllCommentsBlogPost($id) {
        return $this
            ->qb
            ->createQueryBuilder('blog_comments bc')
            ->selectSql('*, bc.id as bc_id')
            ->leftJoin('users u ON u.id = bc.user_id WHERE bc.blog_id = \'' . intval($id) . '\'')
            ->limit(20)
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return array
     */
    public function getLastCommentsBlogPostByUser($id) {
        global $userInfo;
        return $this
            ->qb
            ->createQueryBuilder('blog_comments bc')
            ->selectSql('*, bc.id as bc_id')
            ->leftJoin('
                users u ON u.id = bc.user_id 
                WHERE bc.blog_id = \'' . intval($id) . '\'
                AND bc.user_id = \'' . $userInfo['id'] . '\''
            )
            ->orderBy('bc.id DESC')
            ->limit(1)
            ->executeQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @param $id
     * @param $text
     * @return bool
     */
    public function blogPostSendComment($id, $text) {

        global $userInfo;

        $text = $this->srv->charsString($text);

        if (empty($text))
            return false;

        return $this
            ->qb
            ->createQueryBuilder('blog_comments')
            ->insertSql(
                [
                   'blog_id',
                   'user_id',
                   'content',
                   'timestamp',
                ], [
                    intval($id),
                    intval($userInfo['id']),
                    $text,
                    $this->srv->timeStampNow()
                ]
            )
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return array
     */
    public function blogPostDeleteComment($id) {
        global $userInfo;
        return $this
            ->qb
            ->createQueryBuilder('blog_comments')
            ->deleteSql()
            ->where('id = \'' . intval($id) . '\'')
            ->andWhere('user_id = \'' . intval($userInfo['id']) . '\'')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $blogId
     * @return bool
     */
    public function blogPostCountComments($blogId) {

        $result = $this
            ->qb
            ->createQueryBuilder('blog_comments')
            ->selectSql('count(*)')
            ->where('blog_id = \'' . intval($blogId) . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;

        return reset($result);
    }

    /**
     * @return array
     */
    public function getTeacherList() {

        return $this
            ->qb
            ->createQueryBuilder('users')
            ->selectSql()
            ->where('type = \'1\'')
            ->limit(50)
            ->orderBy('verify DESC, rating DESC, name ASC')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @return array
     */
    public function getAuthLog() {
        global $userInfo;
        return $this
            ->qb
            ->createQueryBuilder('log_auth')
            ->selectSql()
            ->where('user_id = \'' . $userInfo['id'] . '\'')
            ->limit(5)
            ->orderBy('id DESC')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @return array
     */
    public function getChangeLog() {
        return $this
            ->qb
            ->createQueryBuilder('log_change')
            ->selectSql()
            ->limit(200)
            ->orderBy('id DESC')
            ->executeQuery()
            ->getResult()
        ;
    }
}