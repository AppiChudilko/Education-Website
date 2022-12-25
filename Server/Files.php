<?php

namespace Server;

if (!defined('AppiEngine')) {
    header( "refresh:0; url=/");
}

/**
 * News
 */
class Files
{
    /**
     * @return array
     */
    public function uploadUserAvatar() {

        global $userInfo;
        global $qb;

        if($userInfo['img_avatar'] != '/client/images/none-ava.png')
            $this->deleteFile($userInfo['img_avatar']);

        $postfixArray = explode('_', $userInfo['img_avatar']);
        $postfix = (empty(end($postfixArray))) ? 0 : end($postfixArray);
        $postfix = intval($postfix);
        $path = '/upload/user/';

        $files = $this->uploadImage(md5('av' . $userInfo['id'] . time()), $path . $userInfo['id'] . '/', $postfix);
        $success = false;

        if(isset($files['files']))
            $success = $qb
                ->createQueryBuilder('users')
                ->updatesql(
                    [
                        'img_avatar'
                    ], [
                        $path . '/' . $userInfo['id'] . '/' . reset($files['files'])
                    ]
                )
                ->where('id = \'' . $userInfo['id'] . '\'')
                ->executeQuery()
                ->getResult()
            ;
        else
            return $files;

        if($success)
            return ['success' => ['message' => 'Аватар успешно обновлён']];

        $this->deleteFile($path . reset($files['files']));
        return ['error' => 'Ошибка загрузки аватара'];
    }

    /**
     * @return array
     */
    public function uploadUserBackground() {

        global $userInfo;
        global $qb;

        if(!strpos($userInfo['img_wallpaper'], '/client/images/wallpaper/'))
            $this->deleteFile($userInfo['img_wallpaper']);

        $postfixArray = explode('_', $userInfo['img_wallpaper']);
        $postfix = (empty(end($postfixArray))) ? 0 : end($postfixArray);
        $postfix = intval($postfix);
        $path = '/upload/user/';

        $files = $this->uploadImage(md5('wp' . $userInfo['id'] . time()), $path . $userInfo['id'] . '/', $postfix);
        $success = false;

        if(isset($files['files']))
            $success = $qb
                ->createQueryBuilder('users')
                ->updatesql(
                    [
                        'img_wallpaper'
                    ], [
                        $path . '/' . $userInfo['id'] . '/' . reset($files['files'])
                    ]
                )
                ->where('id = \'' . $userInfo['id'] . '\'')
                ->executeQuery()
                ->getResult()
            ;
        else
            return $files;

        if($success)
            return ['success' => ['message' => 'Фон успешно обновлён']];

        $this->deleteFile($path . reset($files['files']));
        return ['error' => 'Ошибка загрузки фона'];
    }

    /**
     * @return array
     */
    public function uploadCourseFile() {

        global $userInfo;
        global $qb;

        $path = '/upload/course/' . $userInfo['id'] . '_' . hash('sha256', time() . '*' . $userInfo['id']) . '/';

        $files = $this->uploadFile(md5('file' . $userInfo['id'] . time()), $path);
        $success = false;

        if(isset($files['files'])) {
            $course = $qb
                ->createQueryBuilder('course')
                ->selectSql()
                ->where('owner_id = \'' . $userInfo['id'] . '\'')
                ->limit(1)
                ->orderBy('id DESC')
                ->executeQuery()
                ->getSingleResult()
            ;

            $format = $this->getFileFormat(reset($files['files']));

            $formatType = 0;

            $formatArrayWord = [
                'doc', 'docx', 'docm', 'dot', 'dotx', 'dotm'
            ];
            $formatArrayExcel = [
                'xls', 'xlsx', 'xlsm', 'xlt', 'xltm', 'xltx', 'xltb', 'xla', 'xlam'
            ];
            $formatArrayPowerPoint = [
                'ptt', 'pttx', 'pttm', 'pps', 'ppsx', 'ppsm', 'pot', 'potx', 'potm', 'ppa', 'ppam'
            ];
            $formatArrayPdf = [
                'pdf'
            ];

            if(in_array($format, $formatArrayWord))
                $formatType = 1;
            else if(in_array($format, $formatArrayExcel))
                $formatType = 2;
            else if(in_array($format, $formatArrayPowerPoint))
                $formatType = 3;
            else if(in_array($format, $formatArrayPdf))
                $formatType = 4;

            if (!empty($course))
                $success = $qb
                    ->createQueryBuilder('course_files')
                    ->insertSql(
                        [
                            'owner_id',
                            'course_id',
                            'title',
                            'path',
                            'type',
                            'timestamp',
                        ], [
                            $userInfo['id'],
                            $course['id'],
                            reset($files['files']),
                            $path . reset($files['files']),
                            $formatType,
                            time(),
                        ]
                    )
                    ->executeQuery()
                    ->getResult()
                ;
        }
        else
            return $files;

        if($success) {
            $file = $qb
                ->createQueryBuilder('course_files')
                ->selectSql()
                ->where('owner_id = \'' . $userInfo['id'] . '\'')
                ->limit(1)
                ->orderBy('id DESC')
                ->executeQuery()
                ->getSingleResult()
            ;

            if (!empty($file))
                return ['success' => ['message' => 'Файл был загружен', 'id' => $file['id']]];
        }

        $this->deleteFile($path . reset($files['files']));
        return ['error' => 'Ошибка загрузки файла'];
    }

    /**
     * @return array
     */
    public function uploadCourseVideo() {

        global $userInfo;
        global $qb;

        $path = '/upload/course/video/' . $userInfo['id'] . '_' . hash('sha256', time() . '*' . $userInfo['id']) . '/';

        $files = $this->uploadVideo(md5('video' . $userInfo['id'] . time()), $path);
        $success = false;

        if(isset($files['files'])) {
            $course = $qb
                ->createQueryBuilder('course')
                ->selectSql()
                ->where('owner_id = \'' . $userInfo['id'] . '\'')
                ->limit(1)
                ->orderBy('id DESC')
                ->executeQuery()
                ->getSingleResult()
            ;

            if (!empty($course))
                $success = $qb
                    ->createQueryBuilder('course_videos')
                    ->insertSql(
                        [
                            'owner_id',
                            'course_id',
                            'title',
                            'path',
                            'timestamp',
                        ], [
                            $userInfo['id'],
                            $course['id'],
                            reset($files['files']),
                            $path . reset($files['files']),
                            time(),
                        ]
                    )
                    ->executeQuery()
                    ->getResult()
                ;
        }
        else
            return $files;

        if($success) {
            $file = $qb
                ->createQueryBuilder('course_videos')
                ->selectSql()
                ->where('owner_id = \'' . $userInfo['id'] . '\'')
                ->limit(1)
                ->orderBy('id DESC')
                ->executeQuery()
                ->getSingleResult()
            ;

            if (!empty($file))
                return ['success' => ['message' => 'Видео было загружено', 'id' => $file['id']]];
        }

        $this->deleteFile($path . reset($files['files']));
        return ['error' => 'Ошибка загрузки видео'];
    }

    /**
     * @return array
     */
    public function uploadImageBlogTemp() {

        global $userInfo;

        $path = '/upload/news/temp';
        $files = $this->uploadImage('blog_' . $userInfo['id'], $path . '/', 0);
        $success = true;

        if($success)
            return ['success' => ['message' => 'Изображение было загружено', 'files' => $files]];

        $this->deleteFile($path . reset($files['files']));
        return ['error' => 'Ошибка загрузки фона'];
    }

    /**
     * @param $fileName
     * @param $newFileName
     * @return array
     */
    public function switchImageBlogTempToNews($fileName, $newFileName) {

        $fileFormat = $this->getFileFormat($fileName);
        $path = '../../edf.byappi.com/public_html/upload/news/temp/';
        $newPath = '../../edf.byappi.com/public_html/upload/news/';

        return rename($path . $fileName, $newPath . $newFileName . '.' . $fileFormat);

        /*if(rename($path . $fileName, $newPath . $newFileName . $fileFormat))
            return ['success' => ['message' => 'Изображение было загружено', 'files' => $files]];

        $this->deleteFile($path . reset($files['files']));
        return ['error' => 'Ошибка загрузки фона'];*/
    }

    /**
     * @param string $imageName
     * @param string $uploadDir
     * @param int $postfix
     * @param int $size
     * @return array
     * @internal param string $successText
     */
    public function uploadImage($imageName, $uploadDir = '/upload/', $postfix = 0, $size = 2) {

        $error = false;
        $files = [];

        $uploadDir = '../../edf.byappi.com/public_html' . $uploadDir;

        $imagesArray = ['jpg', 'png', 'gif', 'jpeg'];

        if(!file_exists($uploadDir))
            mkdir($uploadDir, 0777 , true);

        foreach($_FILES as $file) {

            $imageFormat = $this->getFileFormat($file['name']);

            if($file["size"] > $size * 1024 * 1024) {
                $this->deleteFile($file['tmp_name']);
                return ['error' => 'Файл слишком велик'];
            }

            if(!in_array($imageFormat, $imagesArray)) {
                $this->deleteFile($file['tmp_name']);
                return ['error' => 'Должна быть картинка!'];
            }

            if( move_uploaded_file( $file['tmp_name'], $uploadDir . basename($file['name']) ) ) {
                $imageName = $imageName . '_' . (++$postfix) . '.' . $imageFormat;
                rename($uploadDir . $file['name'], $uploadDir . $imageName);
                $files[] = $imageName;
            }
            else
                $error = true;
        }

        return $error ? ['error' => 'Ошибка загрузки файлов.'] : ['files' => $files];
    }

    /**
     * @param string $fileName
     * @param string $uploadDir
     * @param int $size
     * @return array
     * @internal param string $successText
     */
    public function uploadFile($fileName, $uploadDir = '/upload/course/', $size = 2) {

        $error = false;
        $files = [];

        $uploadDir = '../../edf.byappi.com/public_html' . $uploadDir;

        $filesArray = [
            'doc', 'docx', 'docm', 'dot', 'dotx', 'dotm',
            'xls', 'xlsx', 'xlsm', 'xlt', 'xltm', 'xltx', 'xltb', 'xla', 'xlam',
            'ptt', 'pttx', 'pttm', 'pps', 'ppsx', 'ppsm', 'pot', 'potx', 'potm', 'ppa', 'ppam',
            'pdf', 'txt'
        ];

        if(!file_exists($uploadDir))
            mkdir($uploadDir, 0777 , true);

        foreach($_FILES as $file) {

            $fileFormat = $this->getFileFormat($file['name']);

            if($file["size"] > $size * 1024 * 1024) {
                $this->deleteFile($file['tmp_name']);
                return ['error' => 'Файл слишком велик'];
            }

            if(!in_array($fileFormat, $filesArray)) {
                $this->deleteFile($file['tmp_name']);
                return ['error' => 'Должен быть TXT / PDF / Word / Excel / PowerPoint документ!'];
            }

            if( move_uploaded_file( $file['tmp_name'], $uploadDir . basename($file['name']) ) ) {
                $fileName = $fileName . '.' . $fileFormat;
                rename($uploadDir . $file['name'], $uploadDir . $fileName);
                $files[] = $fileName;
            }
            else
                $error = true;
        }

        return $error ? ['error' => 'Ошибка загрузки файлов.'] : ['files' => $files];
    }

    /**
     * @param string $fileName
     * @param string $uploadDir
     * @param int $size
     * @return array
     * @internal param string $successText
     */
    public function uploadVideo($fileName, $uploadDir = '/upload/course/video/', $size = 16) {

        $error = false;
        $files = [];

        $uploadDir = '../../edf.byappi.com/public_html' . $uploadDir;

        $filesArray = [
            'mp4', 'avi', 'wmv', 'mov', 'mpeg'
        ];

        if(!file_exists($uploadDir))
            mkdir($uploadDir, 0777 , true);

        foreach($_FILES as $file) {

            $fileFormat = $this->getFileFormat($file['name']);

            if($file["size"] > $size * 1024 * 1024) {
                $this->deleteFile($file['tmp_name']);
                return ['error' => 'Файл слишком велик'];
            }

            if(!in_array($fileFormat, $filesArray)) {
                $this->deleteFile($file['tmp_name']);
                return ['error' => 'Должен быть MP4 / AVI / WMW / MOV / MPEG!'];
            }

            if( move_uploaded_file( $file['tmp_name'], $uploadDir . basename($file['name']) ) ) {
                $fileName = $fileName . '.' . $fileFormat;
                rename($uploadDir . $file['name'], $uploadDir . $fileName);
                $files[] = $fileName;
            }
            else
                $error = true;
        }

        return $error ? ['error' => 'Ошибка загрузки файлов.'] : ['files' => $files];
    }

    /**
     * @param string $path
     * @return bool
     */
    public function deleteFile($path) {
        if (file_exists('../../edf.byappi.com/public_html/' . $path))
            return unlink('../../edf.byappi.com/public_html/' . $path);
        return false;
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function getFileFormat($fileName) {
        $img = explode('.', $fileName);
        return end($img);
    }
}