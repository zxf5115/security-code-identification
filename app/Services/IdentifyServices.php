<?php
namespace App\Services;

/**
 * 图片识别
 */
class IdentifyServices
{
  private $ImagePath = null;
  private $ImageSize = null;
  private $ImageInfo = null;


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-11
   * ------------------------------------------
   * 初始化传递图片地址
   * ------------------------------------------
   *
   * @param string $path 图片地址
   */
  public function __construct($path)
  {
    $this->ImagePath = $path;

    $this->ImageSize = getimagesize($path);

    $this->getPictureInfo();
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-11
   * ------------------------------------------
   * 获取图像标识符
   * ------------------------------------------
   *
   * 获取图像标识符，保存到ImageInfo，只能处理png,jpg图片
   *
   * @return [type]
   */
  public function getPictureInfo()
  {
    $filetype = substr($this->ImagePath, -3);

    if($filetype == 'jpg')
    {
      $this->ImageInfo = imagecreatefromjpeg($this->ImagePath);
    }
    else if($filetype == 'png')
    {
      $this->ImageInfo = imagecreatefrompng($this->ImagePath);
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-11
   * ------------------------------------------
   * 获取图片的RGB
   * ------------------------------------------
   *
   * 获取图片的RGB
   *
   * @return [type]
   */
  function getRgbInfo()
  {
    $rgbArray = array();

    $res = $this->ImageInfo;
    $size = $this->ImageSize;

    $wid = $size['0'];
    $hid = $size['1'];

    for($i=0; $i < $hid; ++$i)
    {
      for($j=0; $j < $wid; ++$j)
      {
        $rgb = imagecolorat($res,$j,$i);

        $rgbArray[$i][$j] = imagecolorsforindex($res, $rgb);
      }
    }

    return $rgbArray;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-11
   * ------------------------------------------
   * 获取图片灰度信息
   * ------------------------------------------
   *
   * 获取图片灰度信息
   *
   * @return [type]
   */
  function getGrayInfo()
  {
    $grayArray = array();
    $size = $this->ImageSize;
    $rgbarray = $this->getRgbInfo();
    $wid = $size['0'];
    $hid = $size['1'];

    for($i=0; $i < $hid; ++$i)
    {
      for($j=0; $j < $wid; ++$j)
      {
        $grayArray[$i][$j] = (
          299 * $rgbarray[$i][$j]['red'] +
          587 * $rgbarray[$i][$j]['green'] +
          144 * $rgbarray[$i][$j]['blue']
        ) / 1000;
      }
    }

    return $grayArray;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-11
   * ------------------------------------------
   * 获取图片的二值信息
   * ------------------------------------------
   *
   * 根据自定义的规则，获取二值化二维数组
   *
   * @return [type]
   */
  function getErzhiInfo()
  {
    $erzhiArray = array();
    $size = $this->ImageSize;
    $grayArray = $this->getGrayInfo();
    $wid = $size['0'];
    $hid = $size['1'];


    for($i=0; $i < $hid; $i++)
    {
      for($j=0; $j <$wid; $j++)
      {

        if($grayArray[$i][$j] > 120 )
        {
          if($i == 0 || $i == $hid - 1)
          {
            $erzhiArray[$i][$j] = 0;
          }
          else if($j == 0 || $j == $wid - 1)
          {
            $erzhiArray[$i][$j] = 0;
          }
          else
          {
            $erzhiArray[$i][$j] = 1;
          }
        }
        else
        {
          $erzhiArray[$i][$j] = 0;
        }
      }
    }

    $erzhiArray = $this->reduceZao($erzhiArray);

    return $erzhiArray;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-11
   * ------------------------------------------
   * 二值化图片降噪
   * ------------------------------------------
   *
   * 二值化图片降噪
   *
   * @param [type] $erzhiArray [description]
   * @return [type]
   */
  function reduceZao($erzhiArray)
  {
    $data = $erzhiArray;
    $gao = count($erzhiArray);
    $chang = count($erzhiArray['0']);

    $jiangzaoErzhiArray = array();

    for($i=0;$i<$gao;$i++)
    {
      for($j=0;$j<$chang;$j++)
      {
        $num = 0;

        if($data[$i][$j] == 1)
        {
          // 上
          if(isset($data[$i-1][$j]))
          {
            $num = $num + $data[$i-1][$j];
          }

           // 下
          if(isset($data[$i+1][$j]))
          {
            $num = $num + $data[$i+1][$j];
          }

          // 左
          if(isset($data[$i][$j-1]))
          {
            $num = $num + $data[$i][$j-1];
          }

          // 右
          if(isset($data[$i][$j+1]))
          {
            $num = $num + $data[$i][$j+1];
          }

          // 上左
          if(isset($data[$i-1][$j-1]))
          {
            $num = $num + $data[$i-1][$j-1];
          }

          // 上右
          if(isset($data[$i-1][$j+1]))
          {
            $num = $num + $data[$i-1][$j+1];
          }

          // 下左
          if(isset($data[$i+1][$j-1]))
          {
            $num = $num + $data[$i+1][$j-1];
          }

          // 下右
          if(isset($data[$i+1][$j+1]))
          {
            $num = $num + $data[$i+1][$j+1];
          }
        }

        if($num < 4)
        {
          $jiangzaoErzhiArray[$i][$j] = 0;
        }
        else
        {
          $jiangzaoErzhiArray[$i][$j] = 1;
        }
      }
    }

    return $jiangzaoErzhiArray;
  }




  /*
   *归一化处理,针对一个个的数字,即去除字符周围的白点
   *@param $singleArray 二值化数组
   */
  function getClearZero($singleArray)
  {
    $dianCount = 0;
    $rearr = array();

    $gao = count($singleArray);
    $kuan = count($singleArray['0']);

    $dianCount = 0;
    $shangKuang = 0;
    $xiaKuang = 0;
    $zuoKuang = 0;
    $youKuang = 0;

    //从上到下扫描
    for($i=0; $i < $gao; ++$i)
    {
      for($j=0; $j < $kuan; ++$j)
      {
        if( $singleArray[$i][$j] == 1)
        {
          $dianCount++;
        }
      }

      if($dianCount > 30)
      {
        $shangKuang = $i;
        $dianCount = 0;
        break;
      }
    }

    //从下到上扫描
    for($i=$gao-1; $i > -1; $i--)
    {
      for($j=0; $j < $kuan; ++$j)
      {
        if( $singleArray[$i][$j] == 1)
        {
          $dianCount++;
        }
      }

      if($dianCount > 30)
      {
        $xiaKuang = $i;
        $dianCount = 0;
        break;
      }
    }

    //从左到右扫描
    for($i=0; $i < $kuan; ++$i)
    {
      for($j=0; $j < $gao; ++$j)
      {
        if( $singleArray[$j][$i] == 1)
        {
          $dianCount++;
        }
      }

      if($dianCount > 30)
      {
        $zuoKuang = $i;
        $dianCount = 0;
        break;
      }
    }
    //从右到左扫描
    for($i=$kuan-1; $i > -1; --$i)
    {
      for($j=0; $j < $gao; ++$j){
        if( $singleArray[$j][$i] == 1)
        {
          $dianCount++;
        }
      }
      if($dianCount > 30)
      {
        $youKuang = $i;
        $dianCount = 0;
        break;
      }
    }

    for($i=0;$i<$xiaKuang-$shangKuang+1;$i++)
    {
      for($j=0;$j<$youKuang-$zuoKuang+1;$j++)
      {
        $rearr[$i][$j] = $singleArray[$shangKuang+$i][$zuoKuang+$j];
      }
    }

    return $rearr;
  }


  public function getLine()
  {
    $data = $this->getErzhiInfo();
    $data = $this->getClearZero($data);

    $data_total = count($data);

    $all = [];

    for($i = $data_total - 1; $i > $data_total - 40; $i--)
    {
      $total = count($data[$i]);
      $sum   = array_sum($data[$i]);

      $offset = NumberServices::getOffset($total);

      if($total == $sum || $total < $sum + $offset)
      {
        $all[] = 1;
      }
      else
      {
        $all[] = 2;
      }
    }

    $status = array_count_values($all);

    if(!empty($status[1]) && $status[1] > 22)
    {
      for($i = $data_total - 5; $i > 0; $i--)
      {
        $sum = array_sum($data[$i]);

        if($sum < 20)
        {
          break;
        }
      }

      if($data_total > $i + 20)
      {
        $one_line   = floor($i / 3 * 1);
        $two_line   = floor($i / 3 * 2);
        $three_line = floor($i / 3 * 3);
      }
    }
    else
    {
      $one_line   = floor($data_total / 4 * 1);
      $two_line   = floor($data_total / 4 * 2);
      $three_line = floor($data_total / 4 * 3);
    }

    $four_line  = $data_total;

    $one   = [];
    $two   = [];
    $three = [];
    $four  = [];

    for($i = 0; $i < $data_total; $i++)
    {
      if($i <= $one_line)
      {
        $one[$i] = $data[$i];
      }

      if($i > $one_line && $i <= $two_line)
      {
        $two[$i] = $data[$i];
      }

      if($i > $two_line && $i <= $three_line)
      {
        $three[$i] = $data[$i];
      }

      if($i > $three_line && $i <= $four_line)
      {
        $four[$i] = $data[$i];
      }
    }

    if(!empty($four))
    {
      $one   = $this->getClearZero(array_values($one));
    }

    if(!empty($four))
    {
      $two   = $this->getClearZero(array_values($two));
    }

    if(!empty($four))
    {
      $three = $this->getClearZero(array_values($three));
    }

    if(!empty($four))
    {
      $four  = $this->getClearZero(array_values($four));
    }

    return [$one, $two, $three, $four];
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-11
   * ------------------------------------------
   * 切割图片每个元素
   * ------------------------------------------
   *
   * 切割成三维数组，每个小数字在一个数组里面
   * 只适用四个数字一起的数组
   *
   * @param array $erzhiArray 经过归一化处理的二值化数组
   * @return [type]
   */
  function cutSmall($erzhiArray)
  {
    $doubleArray = array();
    $jieZouyou = array();

    $gao = count($erzhiArray);
    $kuan = count($erzhiArray['0']);

    $jie = 0;
    $s = 0;
    $jieZouyou[$s] = 0;
    $s++;

    //从左到右扫描
    for($i=0; $i < $kuan;)
    {
      for($j=0; $j < $gao; ++$j)
      {
        $jie = $jie + $erzhiArray[$j][$i];
      }

      //如果有一列全部是白，设置$jieZouyou,并且跳过中间空白部分
      if($jie == 0)
      {
        $jieZouyou[$s] = $i+1;

        do
        {
          $n = ++$i;
          $qian = 0;
          $hou = 0;
          for($m=0; $m < $gao; ++$m)
          {
            $qian = $qian + $erzhiArray[$m][$n];
            $hou = $hou + $erzhiArray[$m][$n+1];
          }

          $jieZouyou[$s+1] = $n+1;
        }

        //当有两列同时全部为白，说明有间隙，循环，知道间隙没有了
        while($qian == 0 && $hou == 0);
        $s+=2;
        $i++;
      }
      else
      {
        $i++;
      }

      $jie = 0;
    }

    $jieZouyou[] = $kuan;
    //极端节点数量，(应该是字符个数)*2
    $jieZouyouCount = count($jieZouyou);

    for($k=0;$k<$jieZouyouCount/2;$k++)
    {
      for($i=0; $i < $gao; $i++)
      {
        for($j=0; $j < $jieZouyou[$k*2+1]-$jieZouyou[$k*2]-1; ++$j)
        {
          $doubleArray[$k][$i][$j] = $erzhiArray[$i][$j+$jieZouyou[$k*2]];
        }
      }
    }

    return $doubleArray;
  }



  public function removeLine($data)
  {
    foreach($data as $kk => $vo)
    {
      $vo_sum = array_sum($vo);
      $vo_total = count($vo);

      if($vo_sum + 20 > $vo_total)
      {
        $three_status[] = $kk;
      }
    }

    if(!empty($three_status))
    {
      $three_linenum = array_shift($three_status);

      for($i = $three_linenum; $i > 0; $i--)
      {
        $linenum_sum = array_sum($data[$i]);

        if($linenum_sum < 10)
        {
          break;
        }
      }

      $data = array_slice($data, 0, $i);

      $data = $this->getClearZero($data);
    }

    return $data;
  }



  public function getNumberInfo($data, $line, $linenum)
  {
    if($linenum == 3)
    {
      $data = $this->removeLine($data);
    }

    $data = $this->cutSmall($data);

    $len = count($data);
    $offset = $len - $line;

    $result = [];

    $number = '';

    foreach($data as $k => $item)
    {
      $all_total = count($item[0]);

      if($linenum == 4)
      {
        if($all_total > 200)
        {
          return false;
        }
      }

      $result[$k] = $all_total;
    }

    rsort($result);

    $all_width  = $result[0];

    foreach($data as $k => $item)
    {
// $item = $data[9];
// dd($item);
      $item = array_values($item);

      if(NumberServices::isZero($item, $all_width))
      {
        $number .= 0;
      }
      else if(NumberServices::isOne($item, $all_width))
      {
        $number .= 1;
      }
      else if(NumberServices::isTwo($item, $all_width))
      {
        $number .= 2;
      }
      else if(NumberServices::isThree($item, $all_width))
      {
        $number .= 3;
      }
      else if(NumberServices::isFour($item, $all_width))
      {
        $number .= 4;
      }
      else if(NumberServices::isFive($item, $all_width))
      {
        $number .= 5;
      }
      else if(NumberServices::isSix($item, $all_width))
      {
        $number .= 6;
      }
      else if(NumberServices::isServer($item, $all_width))
      {
        $number .= 7;
      }
      else if(NumberServices::isEight($item, $all_width))
      {
        $number .= 8;
      }
      else if(NumberServices::isNine($item, $all_width))
      {
        $number .= 9;
      }
      else
      {
        $number .= 'a';
      }
    }

    return $number;
  }















  /*根据灰度信息打印图片*/
  function printByGray($data)
  {
    for($i=0; $i < count($data); ++$i)
    {
      for($j=0; $j < count($data[$i]); ++$j)
      {
        if($data[$i][$j] == 1)
        {
          echo '2';
        }
        else
        {
          echo '0';
        }
      }
      echo "|\n";
    }
  }
}
