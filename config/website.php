<?php
return [
    'upload_path'=>env('UPLOAD_PATH','/upload'),//文件上传路径
    'is_oss'=>env('IS_OOS',0),
    'oss_domain'=>env('OOS_DOMAIN','')
];
?>