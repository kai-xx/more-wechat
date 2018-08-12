<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:41
 */

namespace App\Endpoints\Message;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\MessageOptions;
use App\Models\WechatMessage;
use App\Models\WechatMessageFansTagOption;
use Illuminate\Support\Facades\DB;

/**
 * 删除消息
 * Class DeleteMessage
 * @package App\Endpoints\Message
 */
class DeleteMessage extends BaseEndpoint
{
    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(int $id){
        $message = (new WechatMessage())->find($id);
        if ($message instanceof WechatMessage) {
            if (!$this->verifyOperationRightsByOaWechatId($message->{WechatMessage::DB_FILED_OA_WECHAT_ID}))
                return $this->resultForApi(400, [], "非法操作");

            try{
                DB::transaction(function () use ($id) {
                    WechatMessage::destroy($id);
                    MessageOptions::where(MessageOptions::DB_FILED_MESSAGE_ID,$id)
                        ->delete();
                    WechatMessageFansTagOption::where(WechatMessageFansTagOption::DB_FILED_MESSAGE_ID, $id)
                        ->update([
                            WechatMessageFansTagOption::DB_FILED_STATE => WechatMessageFansTagOption::STATE_CLOSE
                        ]);
                });
                return $this->resultForApi(200, $id);
            }catch (\Exception $e) {
                app('log')->error("删除失败，原因" . $e->getMessage());
                return $this->resultForApi(400, [], "操作失败");
            }
        } else {
            return $this->resultForApi(400, [], "信息不存在");
        }

    }
}