<?php
namespace App\Services;

use Grafika\Grafika;
use App\Models\Fake;

/**
 * 生成防伪码图片
 */
class GenerateServices
{
    protected static $editor;


    protected static $code = [
        '0.jpg',
        '1.jpg',
        '2.jpg',
        '3.jpg',
        '4.jpg',
        '5.jpg',
        '6.jpg',
        '7.jpg',
        '8.jpg',
        '9.jpg'
    ];



    /**
     * @author zhangxiaofei [<1326336909@qq.com>]
     * @dateTime 2020-04-17
     * ------------------------------------------
     * 解析图片
     * ------------------------------------------
     *
     * 具体描述一些细节
     *
     * @param [type] $url [description]
     * @return [type]
     */
    public static function parsePicture($data)
    {
      list($msec, $sec) = explode(' ', microtime());
      $dir = strval($sec) . strval(($msec * 10000000));

      $dir = 'tmp'. DIRECTORY_SEPARATOR . $dir;
      if(!mkdir($dir, 0755, true))
      {
          \Log::error('dir create ERROR!');
      }

      if(empty(self::$editor))
      {
          self::$editor = Grafika::createEditor();
      }

      $filename = self::saveTmpPicture($data, $dir);

      self::$editor->open($image, $filename);
      $filter = Grafika::createFilter('Invert');
      self::$editor->apply($image, $filter );
      self::$editor->save($image, $filename);

      $identify = new IdentifyServices($filename);
      list($one, $two, $three, $four) = $identify->getLine();
// $identify->printByGray($one);
      // 解析防伪码第一行
      $one_line = $identify->getNumberInfo($one, 13, 1);

      $response['country']        = substr($one_line, 0, 2); // 2位
      $response['factory']        = substr($one_line, 2, 2); // 2位
      $response['category']       = substr($one_line, 4, 3); // 3位
      $response['check_code']     = substr($one_line, 7, 6); // 6位

      // 解析防伪码第二行
      $two_line = $identify->getNumberInfo($two, 13, 2);
      $response['child_category'] = substr($two_line, 0, 2); // 2位
      $response['id']             = intval(substr($two_line, 2, 11)); // 11位

      // 解析防伪码第三行
      $three_line = $identify->getNumberInfo($three, 12, 3);
      $response['time_code']      = substr($three_line, 0, 12); // 12位

      // 如果刮开了密码，解析第四行

      // 解析防伪码第四行
      $four_line = $identify->getNumberInfo($four, 12, 4);
      $response['password']      = substr($four_line, 0, 12); // 12位


      if(is_dir($dir))
        self::deldir($dir);
dd($response);
      return $response;
    }






    /**
     * @author zhangxiaofei [<1326336909@qq.com>]
     * @dateTime 2020-04-17
     * ------------------------------------------
     * 生成防伪码图片
     * ------------------------------------------
     *
     * 生成防伪码图片
     *
     * @param array $data 参数数据
     * @return 图片地址
     */
    public static function generatePicture($data)
    {
        try
        {
            $dir = public_path() . DIRECTORY_SEPARATOR . 'code' . DIRECTORY_SEPARATOR;

            if(empty(self::$editor))
            {
                self::$editor = Grafika::createEditor();
            }

            // 第一行
            $country    = $data['country'];    // 2位
            $factory    = $data['factory'];    // 2位
            $category   = $data['category'];   // 3位
            $check_code = $data['check_code']; // 6位
            $one_line = $country.$factory.$category.$check_code;

            // 第二行
            $child_category = $data['child_category'];    // 2位
            $id = str_pad($data['id'], 11, 0, STR_PAD_LEFT);    // 11位
            $two_line = $child_category.$id;

            // 第三行
            $three_line = $data['time_code'];    // 12位

            // 第四行
            $four_line = Fake::getPassword($data['password']); // 12位

            $empty_img = $dir . '10.jpg';

            // 打开一个空白图片
            self::$editor->open($image , $empty_img);

            // 写入第一行防伪码
            for($i = 0; $i < strlen($one_line); $i++)
            {
                $w = ($i) * 40 ?: 10;
                $custor = $one_line[$i];

                self::$editor->open($image2 , $dir . self::$code[$custor]);
                self::$editor->blend($image, $image2 , 'normal', 1, 'top-left', $w, 10);
            }

            // 写入第二行防伪码
            for($i = 0; $i < strlen($two_line); $i++)
            {
                $w = ($i) * 40 ?: 10;
                $custor = $two_line[$i];

                self::$editor->open($image2 , $dir . self::$code[$custor]);
                self::$editor->blend($image, $image2 , 'normal', 1, 'top-left', $w, 50);
            }

            // 写入第三行防伪码
            for($i = 0; $i < strlen($three_line); $i++)
            {
                $w = ($i) * 40 ?: 10;
                $custor = $three_line[$i];

                self::$editor->open($image2 , $dir . self::$code[$custor]);
                self::$editor->blend($image, $image2 , 'normal', 1, 'top-left', $w, 90);
            }

            // // 写入第四行防伪码
            for($i = 0; $i < strlen($four_line); $i++)
            {
                $w = ($i) * 40 ?: 10;
                $custor = $four_line[$i];

                self::$editor->open($image2 , $dir . self::$code[$custor]);
                self::$editor->blend($image, $image2 , 'normal', 1, 'top-left', $w, 130);
            }

            $url = 'security' . DIRECTORY_SEPARATOR . $category . DIRECTORY_SEPARATOR . $child_category;
            $filename = md5(time() . $id);

            $path = $url . DIRECTORY_SEPARATOR . $filename . '.jpg';

            $sava_path = public_path() . DIRECTORY_SEPARATOR . $path;

            $response = self::$editor->save($image, $sava_path);

            return $path;
        }
        catch(\Exception $e)
        {
            \Log::error($e->getMessage());
        }
    }




    /**
     * @author zhangxiaofei [<1326336909@qq.com>]
     * @dateTime 2020-04-17
     * ------------------------------------------
     * 保存图片到临时目录
     * ------------------------------------------
     *
     * 具体描述一些细节
     *
     * @param string $data 图片内容
     * @return [type]
     */
    public static function saveTmpPicture($data, $dir)
    {
        try
        {
            $filename = $dir . DIRECTORY_SEPARATOR . time() . '.jpg';
            $data = base64_decode($data);

            file_put_contents($filename, $data);

            return $filename;
        }
        catch(\Exception $e)
        {
            \Log::error($e->getMessage());
        }
    }










    // ---------------------------------------------


    const FILE_NOT_FOUND = '-1';

  const FILE_EXTNAME_ILLEGAL = '-2';

  private function __construct() {}

  public static function run($src1, $src2) {

    static $self;

    if(!$self) $self = new static;

    if(!is_file($src1) || !is_file($src2)) exit(self::FILE_NOT_FOUND);

    $hash1 = $self->getHashValue($src1);

    $hash2 = $self->getHashValue($src2);

    if(strlen($hash1) !== strlen($hash2)) return false;

    $count = 0;

    $len = strlen($hash1);

    for($i = 0; $i < $len; $i++) if($hash1[$i] !== $hash2[$i]) $count++;

    return $count <= 1 ? true : false;

  }

  public function getImage($file) {

    $extname = pathinfo($file, PATHINFO_EXTENSION);

    if(!in_array($extname, ['jpg','jpeg','png','gif'])) exit(self::FILE_EXTNAME_ILLEGAL);

    $img = call_user_func('imagecreatefrom'. ( $extname == 'jpg' ? 'jpeg' : $extname ) , $file);

    return $img;

  }

  public function getHashValue($file) {

    $w = 8;

    $h = 8;

    $img = imagecreatetruecolor($w, $h);

    list($src_w, $src_h) = getimagesize($file);

    $src = $this->getImage($file);

    imagecopyresampled($img, $src, 0, 0, 0, 0, $w, $h, $src_w, $src_h);

    imagedestroy($src);

    $total = 0;

    $array = array();

    for( $y = 0; $y < $h; $y++) {

      for ($x = 0; $x < $w; $x++) {

        $gray = (imagecolorat($img, $x, $y) >> 8) & 0xFF;

        if(!isset($array[$y])) $array[$y] = array();

        $array[$y][$x] = $gray;

        $total += $gray;

      }

    }

    imagedestroy($img);

    $average = intval($total / ($w * $h * 2));

    $hash = '';

    for($y = 0; $y < $h; $y++) {

      for($x = 0; $x < $w; $x++) {

        $hash .= ($array[$y][$x] >= $average) ? '1' : '0';

      }

    }

    // var_dump($hash);

    return $hash;

  }




    public static function deldir($dir)
    {
        //先删除目录下的文件：
        $dh=opendir($dir);

        while ($file=readdir($dh))
        {
            if($file!="." && $file!="..")
            {
                $fullpath=$dir."/".$file;

                if(!is_dir($fullpath))
                {
                    unlink($fullpath);
                }
                else
                {
                    deldir($fullpath);
                }
            }
        }

        closedir($dh);

        //删除当前文件夹：
        if(rmdir($dir))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
