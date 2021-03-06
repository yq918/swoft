<?php
/**
 * 聊天记录 MODEL层 具体的数据库操作
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Models\Dao;

use Swoft\App;
use Swoft\Bean\Annotation\Bean;
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use App\Models\Entity\LiveComment;

/**
 * @Bean()
 * @uses      LiveCommentDao
 * @version   2017年10月15日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class LiveCommentDao
{

    private $fields = ['id','game_id','user_id','content','add_date'];

    /**
     * 保存聊天记录
     * @param int $game_id
     * @param $data
     * @return mixed
     */
    public  function saveCommentData($game_id,$data)
    {
        $values = [
             [
                'game_id'   => $game_id,
                'user_id' => isset($data['user_id']) ? $data['user_id'] : '',
                'content'   => isset($data['content']) ? $data['content'] : '',
                'add_date'  => time(),
             ],
         ];
        return  LiveComment::batchInsert($values)->getResult();
    }


    /**
     * 根据 game_id查询消息列表
     * @param $game_id
     * @param $orderBy
     * @param $start
     * @param $limit
     * @return array
     */
    public function getCommentListByGameId($game_id,$orderBy=[],$start,$limit)
    {
        $result =  LiveComment::findAll(['game_id' => $game_id ],['fields' => $this->fields,'orderby' => $orderBy,'offset'=>$start,'limit' => $limit])->getResult();
        return empty($result) ? [] : $result->toArray();
    }

    /**
     * 根据game_id 和用户ID获取在一段时间内的聊天总数
     * @param $game_id
     * @param $user_id
     * @param string $startTime
     * @param string $endTime
     * @return int
     */
    public function getCommentCountByGameId($game_id,$user_id,$startTime='',$endTime='')
    {
        $where = [
            'game_id' => $game_id,
            'user_id' => $user_id
        ];
        if(!empty($startTime) && !empty($endTime)){
            $where[] = ['add_date','between',$startTime,$endTime];
        }
         return  LiveComment::count('id',$where)->getResult();
    }



}