<?php
namespace Server;

use Server\Core\QueryBuilder;
use Server\Core\Server;

if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

class Course
{
    protected $qb;
    protected $srv;

    function __construct(QueryBuilder $qb, Server $server)
    {
        $this->qb = $qb;
        $this->srv = $server;
    }

    /**
     * @param $title
     * @param $courseId
     * @param $content
     * @param $imgPath
     * @return bool
     */
    public function addArticle($title, $content, $imgPath, $courseId) {

        global $user;
        global $userInfo;

        if (!$user->isAuthorization())
            return false;

        if (!$user->isTeacher())
            return false;

        $course = $this->getById($courseId);

        if ($course['owner_id'] != $userInfo['id'])
            return false;

        $title = $this->srv->charsString($title);
        $content = $this->srv->charsString($content);

        return $this
            ->qb
            ->createQueryBuilder('course_article')
            ->insertSql(
                [
                    'owner_id',
                    'course_id',
                    'title',
                    'content',
                    'img',
                    'timestamp'
                ],
                [
                    $userInfo['id'],
                    intval($courseId),
                    $title,
                    $content,
                    $imgPath,
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
     * @param $courseId
     * @param $content
     * @param $imgPath
     * @return bool
     */
    public function editArticle($id, $title, $content, $courseId, $imgPath = '') {

        global $user;
        global $userInfo;

        if (!$user->isAuthorization())
            return false;

        if (!$user->isTeacher())
            return false;

        $course = $this->getById($courseId);

        if ($course['owner_id'] != $userInfo['id'])
            return false;

        $title = $this->srv->charsString($title);
        $content = $this->srv->charsString($content);

        if (!empty($imgPath)) {

            $result = $this
                ->qb
                ->createQueryBuilder('course_article')
                ->selectSql()
                ->where('owner_id = \'' . $userInfo['id'] . '\'')
                ->andWhere('id = \'' . intval($id) . '\'')
                ->executeQuery()
                ->getSingleResult()
            ;

            if (!empty($result)) {

                if ($result['img'] != '/client/images/wallpapers/0.jpg') {
                    $file = new Files();
                    $file->deleteFile($result['img']);
                }


                return $this
                    ->qb
                    ->createQueryBuilder('course_article')
                    ->updateSql(
                        [
                            'title',
                            'content',
                            'course_id',
                            'img'
                        ],
                        [
                            $title,
                            $content,
                            intval($courseId),
                            $imgPath
                        ]
                    )
                    ->where('owner_id = \'' . $userInfo['id'] . '\'')
                    ->andWhere('id = \'' . intval($id) . '\'')
                    ->executeQuery()
                    ->getResult()
                    ;
            }
            return false;
        }
        return $this
            ->qb
            ->createQueryBuilder('course_article')
            ->updateSql(
                [
                    'title',
                    'course_id',
                    'content'
                ],
                [
                    $title,
                    intval($courseId),
                    $content
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
    public function deleteArticle($id) {

        global $user;

        if (!$user->isAuthorization())
            return false;

        global $userInfo;

        $result = $this
            ->qb
            ->createQueryBuilder('course_article')
            ->selectSql()
            ->where('owner_id = \'' . $userInfo['id'] . '\'')
            ->andWhere('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getSingleResult()
        ;

        if (!empty($result)) {

            if ($result['img'] != '/client/images/wallpapers/0.jpg') {
                $file = new Files();
                $file->deleteFile($result['img']);
            }

            return $this
                ->qb
                ->createQueryBuilder('course_article')
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
    public function getArticleList($id, $limit = 200) {
        return $this
            ->qb
            ->createQueryBuilder('course_article')
            ->selectSql()
            ->where('owner_id = \'' . intval($id) . '\'')
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
    public function getArticleListByCourseId($id, $limit = 200) {
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
    public function getArticleById($id) {

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
    public function editFile($id, $title, $courseId) {

        global $user;
        global $userInfo;

        if (!$user->isAuthorization())
            return false;

        if (!$user->isTeacher())
            return false;

        $course = $this->getById($courseId);

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
    public function deleteFile($id) {

        global $user;
        global $userInfo;

        if (!$user->isAuthorization())
            return false;

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
    public function getFileById($id) {
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
    public function getFileListByCourseId($id, $limit = 200) {
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
    public function getFileListByOwnerId($limit = 200) {

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
     * @param $title
     * @param $titleDesc
     * @param $content
     * @param $price
     * @param $color
     * @param $colorText
     * @return bool
     */
    public function add($title, $titleDesc, $content, $price, $color, $colorText) {

        global $user;
        global $userInfo;

        if (!$user->isAuthorization())
            return false;

        if (!$user->isTeacher())
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
    public function edit($id, $title, $titleDesc, $content, $price, $color, $colorText) {

        global $userInfo;
        global $user;

        if (!$user->isAuthorization())
            return false;

        if (!$user->isTeacher())
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
    public function delete($id) {

        global $user;

        if (!$user->isAuthorization())
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
    public function getListByOwnerId($id, $limit = 200) {
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
    public function getList($limit = 200) {
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
    public function getById($id) {
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
     * @param $id
     * @return bool
     */
    public function setLike($id) {

        global $userInfo;

        if ($this->isSetLike($id))
            return false;

        $result = $this
            ->qb
            ->createQueryBuilder('course_rating_list')
            ->insertSql(['user_id', 'course_id', 'type'], [$userInfo['id'], intval($id), 0])
            ->executeQuery()
            ->getResult()
        ;

        $this->updateRating($id);

        return $result;
    }

    /**
     * @param $id
     * @return bool
     */
    public function setDisLike($id) {

        global $userInfo;

        if ($this->isSetLike($id))
            return false;

        $result = $this
            ->qb
            ->createQueryBuilder('course_rating_list')
            ->insertSql(['user_id', 'course_id', 'type'], [$userInfo['id'], intval($id), 1])
            ->executeQuery()
            ->getResult()
        ;

        $this->updateRating($id);

        return $result;
    }

    /**
     * @param $id
     * @return bool
     */
    public function isSetLike($id) {

        global $userInfo;

        return !empty(
            $this
                ->qb
                ->createQueryBuilder('course_rating_list')
                ->selectSql()
                ->where('user_id = \'' . $userInfo['id'] . '\'')
                ->andWhere('course_id = \'' . intval($id) . '\'')
                ->executeQuery()
                ->getSingleResult()
            )
        ;
    }

    /**
     * @param $id
     * @return bool
     */
    public function getCountLikes($id) {

        $result = $this
            ->qb
            ->createQueryBuilder('course_rating_list')
            ->selectSql('count(*)')
            ->where('course_id = \'' . intval($id) . '\'')
            ->andWhere('type = \'0\'')
            ->executeQuery()
            ->getSingleResult()
        ;

        return reset($result);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getCountDisLikes($id) {

        $result = $this
            ->qb
            ->createQueryBuilder('course_rating_list')
            ->selectSql('count(*)')
            ->where('course_id = \'' . intval($id) . '\'')
            ->andWhere('type = \'1\'')
            ->executeQuery()
            ->getSingleResult()
        ;

        return reset($result);
    }

    /**
     * @param $id
     * @return bool
     */
    public function updateRating($id) {
        return $this
            ->qb
            ->createQueryBuilder('course')
            ->updateSql(['rating'], [$this->getRating($id)])
            ->where('id = \'' . intval($id) . '\'')
            ->executeQuery()
            ->getResult()
        ;
    }

    /**
     * @param $id
     * @return int
     */
    public function getRating($id) {
        return $this->getCountLikes($id) - $this->getCountDisLikes($id);
    }
}