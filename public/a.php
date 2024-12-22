<?php

/**
 * @author: zhangxiaofei 1326336909@qq.com
 * @dateTime:   2020-04-22 19:07:30
 */



$data = [
    'wxapp_id'       => 10012,
    'sales_order_no' => 'SO20022056740001',
    'old_goods_no'   => 222222,
    'new_goods_no'   => 'DPS00302',
    'timestamp'      => 1590748813
];

// 对数组的值按key排序
ksort($data);
// 生成url的形式
$params = http_build_query($data);
// 生成sign
$sign = md5($params .'B2Z0S1H9D7Z18');

echo $sign;

exit;


$s = file_get_contents('2/2.jpg');

echo base64_encode($s);
