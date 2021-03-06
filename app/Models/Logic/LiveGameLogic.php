<?php
/**
 * 赛程表 逻辑层 逻辑业务处理
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Models\Logic;

use Swoft\App;
use App\Models\Entity\LiveGameSchedule;
use App\Models\Entity\LiveMatchTable;
use Swoft\Bean\Annotation\Bean;
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use App\Models\Logic\LiveMatchLogic;
use App\Models\Logic\LiveAdminUserLogic;
use App\Models\Logic\LiveCommentaryLogic;

use Swoft\Bean\Annotation\Inject;
use App\Models\Dao\LiveGameDao;
use App\Models\Dao\LiveTeamDao;

/**
 * @Bean()
 * @uses      LiveGameLogic
 * @version   2017年10月15日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class LiveGameLogic
{
    /**
     *
     * @Inject()
     * @var LiveGameDao
     */
     private  $LiveGameDao;

    /**
     * 先判断是否存在，如果不存在则插入，如果存在则直接返回true
     * @param $data
     * @return bool|mixed
     */
    public function saveLiveGame($data)
    {
        if(empty($data) || empty($data['game_date']) || empty($data['data_time']) || empty($data['match_id'])){
            return 0 ;
        }
        return $this->LiveGameDao->saveLiveGame($data);
    }

    /**
     * 根据ID 查询赛事信息
     * @param int $game_id
     * @return array
     */
    public function getGameDataByGameId(int $game_id)
    {
        if(empty($game_id)){
            return [];
        }
        return $this->LiveGameDao->getGameDataByGameId($game_id);
    }

    /**
     * 修改数据
     * @param $game_id
     * @param $data
     * @return  boolean
     */
    public function updateGameDataById($game_id,$data)
    {
        if(empty($game_id) || empty($data)){
             return false;
        }
       return $this->LiveGameDao->updateGameDataById($game_id,$data);
    }

    /**
     * 删除赛事数据
     * @param $game_id
     * @return bool
     */
    public function delGameDataById($game_id)
    {
        return  $this->updateGameDataById($game_id,['live_status' => 0]);
    }

    /**
     * 根据时间查询赛事列表
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function getGameListDataByDate($startDate,$endDate)
    {
        $result = $this->LiveGameDao->getGameDataByDate($startDate,$endDate);
        return  $this->getGameListData($result);
    }

    /**
     * 按时间条件修改比赛状态，
     * @param $startDate
     * @param $endDate
     * @param $status
     * @return array
     */
    public function updateGameStatus($startDate,$endDate,$status)
    {
       return  $this->LiveGameDao->updateGameStatus($startDate,$endDate,$status);
    }

    /**
     * 根据条件查询赛事列表
     * @param $where
     * @param array $fields
     * @param array $orderBy
     * @param $start
     * @param $limit
     * @return array
     */
    public function getGameListDataByWhere($where=[],$orderBy=[],$start=0,$limit=10)
    {
        $result = $this->LiveGameDao->getGameListDataByWhere($where,$orderBy,$start,$limit);
        return  $this->getGameListData($result,false);
    }

    /**
     * 根据条件查询总数
     * @param array $where
     * @return array
     */
    public function getGameCountByWhere($where=[])
    {
       return  $this->LiveGameDao->getGameCountByWhere($where);
    }


    /**
     * 查询赛事列表数据
     * @param array $result
     * @param bool $isTimeSub
     * @return array
     */
    public function getGameListData($result,$isTimeSub=true)
    {
        $match_id_list = array_column($result,'matchId');
        $team_id_list  = array_column($result,'homeTeamId');
        $game_id_list  = array_column($result,'id');
        $live_member_id_list = array_column($result,'liveMemberId');
        $team_id_list  = array_merge($team_id_list,array_column($result,'visitingTeamId'));

        $match_id_list = array_unique($match_id_list);
        $match_id_list = array_filter($match_id_list);

        $team_id_list = array_unique($team_id_list);
        $team_id_list = array_filter($team_id_list);

        $live_member_id_list = array_unique($live_member_id_list);
        $live_member_id_list = array_filter($live_member_id_list);

        /* @var LiveMatchLogic $matchLogic */
        $matchLogic = App::getBean(LiveMatchLogic::class);
        $matchData =  $matchLogic->getMatchDataByIdList($match_id_list);

        /* @var LiveTeamLogic $teamLogic */
        $teamLogic = App::getBean(LiveTeamLogic::class);
        $teamList = $teamLogic->getTeamDataByIdList($team_id_list);

        /* @var LivePlayLogic $playLogic */
        $playLogic = App::getBean(LivePlayLogic::class);
        $playData =  $playLogic->getPlayDataById($game_id_list);

        /* @var LiveAdminUserLogic $adminLogic */
        $adminLogic = App::getBean(LiveAdminUserLogic::class);
        $narratorData = $adminLogic->getUserDataById($live_member_id_list);

        $data =  $this->processGameListData($result,$matchData,$teamList,$playData,$narratorData,$isTimeSub);
        return $data;
    }



    /**
     * 根据ID 整理赛事信息
     * @param int $game_id
     * @return array
     */
    public function processGameDataById(int $game_id)
    {
        $gameData = $this->getGameDataByGameId($game_id);
        if(empty($gameData)){
             return [];
        }
        //球队信息
        $teamData = $this->processTeamData($gameData['homeTeamId'],$gameData['visitingTeamId']);
        $narratorData = [];
        $commentaryData = [];
        //解说员信息
        if($gameData['liveMemberId']){
            /* @var LiveAdminUserLogic $adminLogic */
            $adminLogic = App::getBean(LiveAdminUserLogic::class);
            $narratorData = $adminLogic->getUserDataById($gameData['liveMemberId']);
         }
         //比赛解说详情信息
        if($gameData['liveStatus'] > 1){
           /* @var LiveCommentaryLogic $commentaryLogicLogic */
           $commentaryLogicLogic = App::getBean(LiveCommentaryLogic::class);
           $commentaryData =  $commentaryLogicLogic->getCommentaryByGameId($gameData['id']);
        }
          //聊天列表
         /* @var LiveCommentLogic $commentLogic */
         $commentLogic = App::getBean(LiveCommentLogic::class);
         $chatData =  $commentLogic->getCommentListByGameId($game_id);

         //播放地址信息
         /* @var LivePlayLogic $playLogic */
         $playLogic = App::getBean(LivePlayLogic::class);
         $playData =  $playLogic->getPlayDataById($gameData['id']);

         /* @var LiveMatchLogic $matchLogic */
          $matchLogic = App::getBean(LiveMatchLogic::class);
          $matchData =  $matchLogic->getMatchDataById($gameData['matchId']);

         $gameData = array_merge($gameData,$teamData);
         $gameData['commentaryData'] = $commentaryData;
         $gameData['narratorData'] = $narratorData;
         $gameData['playData'] = $playData;
         $gameData['matchData'] = $matchData;
         $gameData['chatData'] = $chatData;
         return $gameData;
    }


    /**
     * 获取 主场和客场球队信息
     * @param $homeTeamId
     * @param $visitingTeamId
     * @return mixed
     */
    public function processTeamData($homeTeamId,$visitingTeamId)
    {
        //球队信息
        $teamData = [];
        if(!empty($homeTeamId) && !empty($visitingTeamId)){
            $teamIdList = array($homeTeamId,$visitingTeamId);
            /* @var LiveTeamLogic $teamLogic */
            $teamLogic = App::getBean(LiveTeamLogic::class);
            $teamData = $teamLogic->getTeamDataByIdList($teamIdList);
        }
        $data['hometeamName'] = isset($teamData[$homeTeamId]) ? $teamData[$homeTeamId]['teamName'] : '';
        $data['hometeamLogo'] = isset($teamData[$homeTeamId]) && !empty($teamData[$homeTeamId]['teamLogo']) ? $teamData[$homeTeamId]['teamLogo']: '/static/zhibo8/images/qitazhudui.png';
        $data['visitingteamName'] = isset($teamData[$visitingTeamId]) ? $teamData[$visitingTeamId]['teamName']: '';
        $data['visitingteamLogo'] = isset($teamData[$visitingTeamId]) && !empty($teamData[$visitingTeamId]['teamLogo']) ? $teamData[$visitingTeamId]['teamLogo'] : '/static/zhibo8/images/qitakedui.png';
        return $data;
    }

    /**
     * 整理赛事列表数据
     * @param $gameData
     * @param $matchData
     * @param $teamList
     * @param $playData
     * @param $narratorData
     * @param $isTimeSub
     * @return array  $data
     */
    public function processGameListData($gameData,$matchData,$teamList,$playData,$narratorData,$isTimeSub=true)
    {
        $data = [];
        $playList = [];
        $currDate = date('Y-m-d');
        $matchList = array_column($matchData,'competitionName','id');
        $weekArr = array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
        foreach($playData as $key => $value){
            $game_id = $value['gameId'];
            $playList[$game_id][] = $value;
        }
        foreach($gameData as $index => $item ){
             if(in_array($item['liveStatus'],[0,3])){
                   continue;
             }
            if($item['gameDate'] == $currDate){
                 $gameTime = strtotime($currDate.' '.$item['dataTime'].':00');
                 if($gameTime+3600*4 <=time()){
                     continue;
                 }
            }
            $gameId = $item['id'];
            $matchId = $item['matchId'];
            $home_team_id = $item['homeTeamId'];
            $visiting_team_id = $item['visitingTeamId'];
            $liveMemberId     = $item['liveMemberId'];
            $weekW = date('w',strtotime($item['gameDate']));
            $item['weekDay'] = $weekArr[$weekW];
            $data[$gameId] = $item;
            $data[$gameId]['competition_name'] = isset($matchList[$matchId]) ? $matchList[$matchId] : '';
            $data[$gameId]['home_team'] = isset($teamList[$home_team_id]) ? $teamList[$home_team_id] : [];
            $data[$gameId]['visiting_team'] = isset($teamList[$visiting_team_id]) ? $teamList[$visiting_team_id] : [];
            $data[$gameId]['play_links'] = isset($playList[$gameId]) ? $playList[$gameId] : [];
            $data[$gameId]['narratorData'] = isset($narratorData[$liveMemberId]) ? $narratorData[$liveMemberId] : [];
        }
        unset($teamData,$matchData,$playData,$gameData);
        if($isTimeSub == false){
              return $data;
        }
        $reData = [];
        foreach($data as $index => $item){
              $gameDate = $item['gameDate'];
              $reData[$gameDate][] = $item;
        }
        return $reData;
    }

}