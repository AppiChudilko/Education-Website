<?php
namespace Server\Core;

class LongPoll
{
    protected $redis;
    protected $qb;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('localhost');
    }

    public function checkAddFriend($id) {
        $result = $this->redis->zRange(EnumConst::NS_USER . EnumConst::NS_FRIENDS . $id, 0, -1);
        if (!empty($result)) {
            $this->qb = new QueryBuilder();
            $this->qb->connectDataBase(EnumConst::DB_HOST, EnumConst::DB_NAME, EnumConst::DB_USER, EnumConst::DB_PASS);

            $html = '';

            foreach ($result as $item) {
                $user = $this->qb->createQueryBuilder('users')->selectSql()->where('id = \'' . $item . '\'')->executeQuery()->getSingleResult();
                $name = (empty($user['name']) && empty($user['surname']) ? $user['login'] : $user['name'] . ' ' . $user['surname']);
                $html .= '
                    <b id="notf_name">Заявка в друзья</b>
			        <br>
			        <label id="notf_text"><a ajax-page="id' . $user['id'] . '" style="padding: 0px; line-height: 0px;">' . $name . '</a> - хочет добавить вас в друзья</label>
			    ';
            }

            $this->redis->del(EnumConst::NS_USER . EnumConst::NS_FRIENDS . $id);
            return $html;
        }
        return 0;
        //$this->redis->zRange($this->namespace, $start, $end);
    }

    public function checkMessage($id) {
        $result = $this->redis->zRange(EnumConst::NS_USER . EnumConst::NS_MESSAGE . $id, 0, -1);

        if ($result = reset($result)) {

            $this->redis->del(EnumConst::NS_USER . EnumConst::NS_MESSAGE . $id);
            $this->qb = new QueryBuilder();
            $this->qb->connectDataBase(EnumConst::DB_HOST, EnumConst::DB_NAME, EnumConst::DB_USER, EnumConst::DB_PASS);

            $user = $this->qb->createQueryBuilder('users')->selectSql()->where('id = \'' . $result . '\'')->executeQuery()->getSingleResult();
            $name = (empty($user['surname']) ? $user['name'] : $user['name'] . ' ' . $user['surname']);

            $message = $this->qb
                ->createQueryBuilder('dialogs')
                ->selectSql()
                ->where('id_to = \'' . $result . '\'')
                ->orderBy('id DESC')
                ->limit(1)
                ->executeQuery()
                ->getSingleResult()
            ;

            $resultMessage = ['text' => htmlspecialchars_decode($message['text']), 'name' => $name, 'id' => $message['id_from']];

            return $resultMessage;
        }
        return 0;
    }
}