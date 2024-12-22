<?php

/**
 * @apiDefine jwt  用户jwt权限验证token
 * @apiHeader {String} Authorization="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM" auth token.
 *
 */


/**
 * @apiDefine sign  用户Signature签名验证验证，将请求的所有参数加进行验签，生成sign，这个时间失效默认60秒后就失效可配置
 * @apiParam {string} app_id=default 多个客户端用于查找对应验证签名key，
 * @apiParam {string} timestamp=15232323323 时间搓
 * @apiParam {string} device_os=mac 客户端系统类型 mac windows ipad ios aos
 * @apiParam {string} [app_ver=1.0.0] app当前版本号
 * @apiParam {string} [device_id=b841fbfb972bdf3cc4f3d360] 设备唯一标识号，用于个推
 * @apiParam {string} [device_ver=IOS 11.0.4] 客户端系统版本号
 * @apiParam {string} sign="b841fbfb972bdf3cc4f3d360b16da3e799e1013d" 签名，将所有请求参数进行签名，若有文件上传则去掉文件字段
 */



/**
 * @apiDefine MyError
 * @apiError UserNotFound The <code>id</code> of the User was not found.
 */



/**
 * @apiDefine Success 请求成功
 * @apiSuccess {String} msg 信息
 * @apiSuccess {int} error 0 代表无错误 非0代表有错误
 * @apiSuccess {String[]}[data]  有数据时返回数据，没有数据时不返回此字段
 * @apiSuccessExample {json} 返回样例:
 * {
 * "error":"0",
 * "msg":"成功",
 * "data":{...}
 * }
 */



/**
 * @apiDefine version 版本号
 * @apiVersion 1.0.0
 */
