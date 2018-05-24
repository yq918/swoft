<?php
/**
 * 直播项目，详情.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Controllers\Live;

use App\Common\Tool\Valitron;
use App\Lib\Valitron\Validator;
use Swoft\App;
use Swoft\Core\Coroutine;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Log\Log;
use Swoft\View\Bean\Annotation\View;
use Swoft\Contract\Arrayable;
use Swoft\Http\Server\Exception\BadRequestException;

use Swoft\Bean\Annotation\Integer;
use Swoft\Bean\Annotation\ValidatorFrom;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Message\Server\Request;
use Swoft\Exception\BadMethodCallException;
use App\Models\Logic\LiveGameLogic;

/**
 * Class GameController
 * @Controller(prefix="/live/detail")
 */
class DetailController
{

    /**
     * 文字直播
     * @RequestMapping("wenzi/{game_id}")
     * @throws BadMethodCallException
     * @View(template="zhibo/detail/wenzi")
     * @param Request $request
     * @param int     $game_id
     * @return Response
     */
    public function wenzi(Request $request,int $game_id)
    {
        if(empty($game_id)){
            throw new BadMethodCallException('非法请求!!!');
        }
        //查询比赛信息 并放入缓存
        /* @var LiveGameLogic $logic */
        $logic = App::getBean(LiveGameLogic::class);
        $data  = $logic->processGameDataById($game_id);
        if(empty($data)){
            throw new BadMethodCallException('非法请求!!!');
        }

        echo '<pre>';
        print_r($data);

        return [ 'data' => $data ];



        //连接websocket

        //websocket push


        echo  $game_id;
    }

}