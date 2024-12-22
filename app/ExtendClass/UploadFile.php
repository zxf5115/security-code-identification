<?php
namespace App\ExtendClass;

use App\Models\System\File;
use Illuminate\Support\Facades\Storage;
use Auth;
use AnyUpload;

class UploadFile
{
    /**
     * 上传配置
     * @param string $type
     * @return array
     */
    public static function config($type = 'images')
    {
        $upload_path=config('website.upload_path');
        $max_size=config_cache_default('config.upload_max',50);
        $max_size=1024*1024*$max_size;//50M默认，这里只是上传限制，还需要修改你的php.ini文件
        $config = [
            'fileType' => $type,
            'nameMd5'=>'md5',
            "maxSize" => $max_size, /* 上传大小限制，单位B */
            "compressEnable" => true, /* 是否压缩图片,默认是true */
            "urlPrefix" => "", /* 图片访问路径前缀 */
            "pathFormat" =>  $upload_path. "/images/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        ];
        switch ($type) {
            case 'image':
                $config['allowFiles'] = [".png", ".jpg", ".jpeg", ".gif", ".bmp",".ico"];
                break;
            case 'zip':
                $config['allowFiles'] = ['zip', ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2"];
                $config['pathFormat'] = $upload_path . "/zips/{yyyy}{mm}{dd}/{time}{rand:6}"; /* 上传保存路径,可以自定义保存路径和文件名格式 */
                break;
            case
            'file':
                $config['allowFiles'] = [
                    ".png", ".jpg", ".jpeg", ".gif", ".bmp",
                    ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg", ".wmv",
                    ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
                    ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
                    ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml",".psd",".ai",".cdr"
                ];
                $config['pathFormat'] = $upload_path . "/files/{yyyy}{mm}{dd}/{time}{rand:6}"; /* 上传保存路径,可以自定义保存路径和文件名格式 */
                break;
            case 'vedio':
                $config['allowFiles'] = [".mp4"];
                $config['pathFormat'] = $upload_path . "/vedios/{yyyy}{mm}{dd}/{time}{rand:6}"; /* 上传保存路径,可以自定义保存路径和文件名格式 */
                break;
            case 'excel':
                $config['allowFiles'] = [
                    ".xls", ".xlsx"
                ];
                $config['pathFormat'] = $upload_path . "/excels/{yyyy}{mm}{dd}/{time}{rand:6}"; /* 上传保存路径,可以自定义保存路径和文件名格式 */
                break;
            default:
                $config['allowFiles'] = [".png", ".jpg", ".jpeg", ".gif", ".bmp"];
                break;
        }


        return $config;
    }

    /**
     *
     * @param $result
     * @param string $type
     * @return bool
     */
    public static function addFileDb($result,$type='admin'){
        //存如数据库
        if($type=='user')
        {
            $create_id=0;
            $create_type='user';
        }else
        {
            $create_id=1;//admin('id');
            $create_type='admin';
        }
        $data = [
            'oss_type' => $result['oss_type'],
            'path' => $result['path'],
            'filename' => $result['filename'],
            'size' => $result['size'],
            'tmp' => $result['tmpname'],
            'user_id'=>$create_id,
            'user_type'=>$create_type,
            'type'=>$result['type'],
            'screen'=>$result['screen'],
            'ext'=>$result['ext'],
            'group_id'=>$result['group_id']
        ];
        return File::add($data);
    }

    public static function addOss($aburl,$url){
        $r=Storage::put($url, file_get_contents($aburl));
        return $r;
    }
    public static function upload($filename = "file", $type = 'image',$method='image',$screen='',$group_id=0,$thumbs=[], $is_oss =false)
    {

        $config = self::config($type);
        //判断是否压缩图片,
        if(count($thumbs)>0)
        {
            $config['thumbs']=$thumbs;
        }

        AnyUpload::config($filename, $config,$method);
        $result = AnyUpload::getFileInfo();
        $result['view_src']=$result['path'];
        if($result['type']!='image')
        {

            $img_pic='';
            if (in_array($result['ext'], ['.xlsx', '.xls'])) {
                $img_pic = 'excel.jpg';
                $img_pic = ___('/admin/images/' . $img_pic);
            }
            if (in_array($result['ext'], ['.doc', '.docx'])) {
                $img_pic = 'word.jpg';
                $img_pic = ___('/admin/images/' . $img_pic);
            }
            if (in_array($result['ext'], ['zip', ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2"])) {
                $img_pic = 'zip.jpg';
                $img_pic = ___('/admin/images/' . $img_pic);
            }
            if (in_array($result['ext'], ['zip', ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2"])) {
                $img_pic = 'zip.jpg';
                $img_pic = ___('/admin/images/' . $img_pic);
            }
            if (in_array($result['ext'], [
                ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg", ".wmv",
                ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid", ".cab", ".iso",
                ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml", ".psd", ".ai", ".cdr"
            ])) {
                $img_pic = 'file.jpg';
                $img_pic = ___('/admin/images/' . $img_pic);
            }

            $result['view_src']=img_url($img_pic);

        }



        $result['screen']=$screen;
        if ($result['success']==1) {
            $result['oss_type']='local';
            $is_oss=$is_oss?$is_oss:config('website.is_oss');
            //如果是OSS
            if ($is_oss == 1) {
                $result['oss_type']='aly_oss';
                if(self::addOss($result['abpath'],$result['path'])){
                    self::deleteLocalFile($result['path'],0);//删除自己路径
                    $result['oss_url']=Storage::url($result['path']);
                    $result['oss_thumb_url']=$result['oss_url'];
                    if($result['type']=='image'){
                        $result['view_src']=$result['oss_url'];
                    }

                    $result['path']=$result['oss_url'];


                }

            }
            $result['group_id']=$group_id;
            self::addFileDb($result);//入库

        }

        return $result;
    }

    /**
     * 删除本地图片
     * @param $filepath
     * @param int $del_db
     * @return bool
     */
    public static function deleteLocalFile($filepath,$del_db=1){
        if(is_array($filepath))
        {
            foreach ($filepath as $v)
            {
                self::deleteLocalFile($v);
            }
        }
        $ofilename=$filepath;
        //附加前缀
        $filepath=linux_path(public_path()).$filepath;
        if (is_dir($filepath)) {
            return false;
        } elseif (file_exists($filepath)) {
            $r = unlink($filepath);
            if ($r) {
                if($del_db)
                {
                    File::where('path',$ofilename)->delete();
                }

                return true;

            }
            return false;
        }

    }

    /**
     * OSS图片删除
     * @param $filepath
     * @return bool
     */
    public static function deleteOssFile($filepath){
        $filepath=is_array($filepath)?$filepath:[$filepath];
        $r=Storage::delete($filepath);
        if($r)
        {
            //从数据库里面删除
            File::whereIn('path',$filepath)->delete();
            return true;
        }
        return false;
    }

    /**
     * 文件删除选择
     * @param string $url
     * @param int $is_oss
     * @return bool
     */
    public static function deleteFile($url='',$is_oss=0)
    {
        $is_oss=$is_oss?$is_oss:config('website.is_oss');
        if($is_oss)
        {
            return self::deleteOssFile($url);
        }else
        {
            return self::deleteLocalFile($url);
        }

    }



}