<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\WeUser;
use App\Library\We;
use App\Model\Member;
use App\Model\Order;
use App\Model\VerifyCode;
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

class OrderService
{

    public function getUserInfo()
    {
        return Member::query()->where('id', getUserInfo('api')->getId())
            ->first();
    }

    public function down(array $keys)
    {
        $orders = Order::query()->whereIn('id', $keys)->with('photo')->get();
        $temp_file = sys_get_temp_dir() . "/" . uniqid() . "/";
        mkdir($temp_file);
        $zipname = $temp_file . 'PhotoPack-' . uniqid() . '.zip';
        $zip = new \ZipArchive;
        $zip->open($zipname, \ZipArchive::CREATE);
        foreach ($orders as $order) {
            list($key, $files) = $this->orderZip($order);
            foreach ($files as $file) {
                $zip->addFile($file, $key . '/' . basename($file));
            }
        }
        $zip->close();
        return $zipname;
    }

    private function orderZip(Order $order)
    {
        $temp_file = sys_get_temp_dir() . "/" . uniqid() . "/";
        if (!is_dir($temp_file)) {
            mkdir($temp_file);
        }
        $readme = $temp_file . "/订单信息.txt";
        $address = $order->address->province
            . $order->address->city
            . $order->address->district
            . $order->address->detail;
        $txt = "上传用户：{$order->user->nickname}\r\n用户ID：{$order->user_id}\r\n上传时间：{$order->create_at}\r\n\r\n订单号：{$order->id }\r\n下单时间：{$order->create_at}\r\n付款时间：{$order->pay_at}
  \r\n邮寄时间：{$order->delivery_at }\r\n\r\n收件人：{$order->address->real_name}\r\n联系电话：{$order->address->phone}\r\n联系地址：{$address}
\r\n\r\n照片故事：\r\n";
        foreach ($order->photo as $photo) {
            $content = json_decode($photo->content, true);
            foreach ($content as $item) {
                $txt .= "姓名：{$item['nickname']}\r\n故事：{$item['content']}\r\n签名：{$item['sign']}\r\n";
            }
        }
        file_put_contents($readme, $txt);
        $path = BASE_PATH . "/public/" . parse_url($photo->image)['path'] ?? '';// str_replace("/", "\\", parse_url($photo->image)['path'] ?? '');
        $path = str_replace("//", "/", $path);
        //$path = str_replace("/", "\\",$path);
        $files[] = $path;
        $files[] = $readme;
        return ['订单-' . $order->id, $files];
    }
}
