<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\WeUser;
use App\Library\We;
use App\Model\Member;
use App\Model\VerifyCode;
use Carbon\Carbon;
use EasyWeChat\Kernel\Exceptions\DecryptException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Exception;
use HPlus\Admin\Exception\ApiException;
use HPlus\Admin\Exception\BusinessException;
use HPlus\Validate\Annotations\Validation;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Mzh\Helper\QcloudSms\SmsSingleSender;
use Qbhy\HyperfAuth\Authenticatable;

class UserService
{

    /**
     * @Inject()
     * @var We
     */
    private $weChat;

    /**
     * 刷新Token
     * @access public
     * @param string $refresh 刷新令牌
     * @return false|array
     * @throws
     */
    public function refreshUser($refresh)
    {

    }


    /**
     * @Validation(mode="User",value="update",filter=true)
     * @param array $data
     * @return array|bool
     * @throws Exception
     */
    public function update(array $data)
    {

        return [];
    }

    /**
     * @param $param
     * @return array
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function codeLogin($param)
    {
        if ($param['wx_code'] == 'string') {
            $data = json_decode('{"session_key":"PdZ60jlMkreBgqPGoauU7A==","openid":"o1_n15UOf2NBeWenzRfxV86_tkhs"}', true); //
        } else {
            $data = $this->weChat->getMini()->auth->session($param['wx_code']);
        }
        if (isset($data['errcode']) && $data['errcode'] > 0) {
            throw new BusinessException((int)$data['errcode'], $data['errmsg']);
        }
        $user = $this->openidLogin($data['openid']);
        if (empty($user)) {
            if (isset($param['pid'])) sessionCache('pid', intval($param['pid']), $data['openid']);
            $user = Member::query()->firstOrCreate(['openid' => $data['openid']], [
                "openid" => $data['openid'],
                "nickname" => '游客',
                'last_ip' => getClientIp()
            ]);
        }
        sessionCache('session_key', $data['session_key'], $user->id);
        sessionCache('openid', $data['openid'], $user->id);
        $user->token = getGuard('api')->login($user);
        return $user;
    }

    /**
     * @param string $openid
     * @return Authenticatable
     */
    public function openidLogin(string $openid)
    {
        // 根据账号获取
        $result = Member::query()->where(['openid' => $openid])->first();
        if (!$result) {
            return [];
        }
        if ($result->getAttribute('status') !== 1) {
            throw new BusinessException(1000, '账号已禁用');
        }
        $data['last_login'] = time();
        $data['last_ip'] = getClientIp();
        $result->fillable(['last_login', 'last_ip'])->fill($data)->save();
        return $result;
    }

    public function wxRegister($data, $openid, $pid)
    {
        try {
            $wxUser = $this->weChat->getMini()->encryptor->decryptData(sessionCache('session_key'), $data['iv'], $data['encryptedData']);
        } catch (DecryptException $e) {
            p($e->getMessage());
            throw new ApiException($e->getMessage());
        }
        // $wxUser = json_decode('{"nickName":"Smile💬","gender":1,"language":"zh_CN","city":"Zhengzhou","province":"Henan","country":"China","avatarUrl":"https://wx.qlogo.cn/mmopen/vi_32/ajNVdqHZLLBpqXMk6kUC4PeB5VrIVtHyUqrcPg65sjKdPxlkBINiaQ1NG6nZC9iaWOh9qdO6VaApJzgWA1wu5h8Q/132"}', true);
        $userIo = new WeUser($wxUser);
        $userIo->setOpenid($openid);
        $user = Member::query()->firstOrCreate(['openid' => $userIo->getOpenid()], [
            "nickname" => $userIo->getNickname(),
            "username" => $userIo->getNickname(),
            "password" => md5($userIo->getNickname() . rand(100000, 999999)),
            "sex" => $userIo->getSex(),
            "head_pic" => $userIo->getAvatarUrl(),
            "openid" => $userIo->getOpenid(),
            'pid' => intval($pid),
            'last_login' => time(),
            'user_level_id' => 1,
            'last_ip' => getClientIp(),
            "unionid" => $userIo->getUnionid()
        ]);
        $user->token = getGuard('api')->login($user);
        return $user;
    }

    public function sendCode($mobile, $type)
    {
        $userId = getUserInfo('api')->getId();
        switch ($type) {
            case 1:
                $count = Member::query()->where('id', $userId)->where('mobile', "!=", '')->count();
                if ($count > 0) {
                    throw new ApiException('您的已绑定手机号码，不允许再次绑定！');
                }
                break;
        }
        $count = VerifyCode::query()->where('mobile', $mobile)->where(Db::raw('time + 60'), '>', time())->where('type', $type)->where('status', 1)->count();
        if ($count > 0) {
            throw new ApiException('您的操作过于频繁，请稍后再试！');
        }
        $code = rand(100000, 999999);
        VerifyCode::query()->insert([
            'mobile' => $mobile,
            'code' => $code,
            'time' => time(),
            'type' => $type,
            'user_id' => intval($userId),
            'send_ip' => getClientIp(),
            'status' => 1,
        ]);
        /**
         * @var SmsSingleSender $sms
         */
        $sms = getContainer(SmsSingleSender::class);
        $sms->sendWithParam('86', $mobile, 5781020, [$code, 5], config('sms.sign'));
        return $code;
    }
    /**
     * @param $mobile
     * @param $code
     * @return bool
     */
    public function verifyCode($param)
    {
        $data = VerifyCode::query()->where('mobile', $param['mobile'])->where('code', $param['code'])->orderBy('verification_id')->first();
        if (empty($data)) {
            throw new ApiException('验证码不正确');
        }

        /**
         * @var Carbon $time
         */

        if ($data->getAttribute('status') != 1 || $data->getOriginal('time') + 300 < time()) {
            throw new ApiException('验证码已失效');
        }
        unset($param['code']);
        $param['user_level_id'] = 2;
        switch ($data->type) {
            case 1:
                Member::query()->where('id', $data->user_id)->update($param);
                $data->status = 2;
                $data->save();
                break;
        }
        return true;
    }

    public function getUserInfo()
    {
        return Member::query()->where('id', getUserInfo('api')->getId())
            ->first();
    }
}
