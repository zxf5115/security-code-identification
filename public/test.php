<?php

class Identify
{
  private $ImagePath = null;
  private $ImageSize = null;
  private $ImageInfo = null;

  public function __construct($path)
  {
    $this->ImagePath = $path;

    $this->ImageSize = getimagesize($path);

    $this->getInfo();
  }



  /*
   * 获取图像标识符，保存到ImageInfo，只能处理png,jpg图片
   */
  public function getInfo()
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


  /*
   * 获取图片RGB信息
   */
  function getRgb()
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



  /*
   *获取灰度信息
   */
  function getGray()
  {
    $grayArray = array();
    $size = $this->ImageSize;
    $rgbarray = $this->getRgb();
    $wid = $size['0'];
    $hid = $size['1'];

    for($i=0; $i < $hid; ++$i)
    {
      for($j=0; $j < $wid; ++$j)
      {
        $grayArray[$i][$j] =
          (
            299 * $rgbarray[$i][$j]['red'] +
            587 * $rgbarray[$i][$j]['green'] +
            144 * $rgbarray[$i][$j]['blue']
          ) / 1000;
      }
    }

    return $grayArray;
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
          echo '1';
        }
        else
        {
          echo '0';
        }
      }
      echo "|\n";
    }
  }



  /*
   *根据自定义的规则，获取二值化二维数组
   *@return  图片高*宽的二值数组（0,1）
   */
  function getErzhi()
  {
    $erzhiArray = array();
    $size = $this->ImageSize;
    $grayArray = $this->getGray();
    $wid = $size['0'];
    $hid = $size['1'];

    for($i=0; $i < $hid; ++$i)
    {
      for($j=0; $j <$wid; ++$j)
      {
        if($grayArray[$i][$j] > 90 )
        {
          $erzhiArray[$i][$j] = 1;
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



  /*
   *二值化图片降噪
   *@param $erzhiArray二值化数组
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

        if($num < 1)
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
  function getJinsuo($singleArray)
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

      if($dianCount>10)
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

      if($dianCount>10)
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

      if($dianCount>10)
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
      if($dianCount>10)
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


  public function getLine($data)
  {
    $one_line   = count($data) / 4 * 1;
    $two_line   = count($data) / 4 * 2;
    $three_line = count($data) / 4 * 3;
    $four_line  = count($data) / 4 * 4;

    $one   = [];
    $two   = [];
    $three = [];
    $four  = [];

    for($i = 0; $i < count($data); $i++)
    {
      if($i < $one_line)
      {
        $one[$i] = $data[$i];
      }

      if($i > $one_line && $i < $two_line)
      {
        $two[$i] = $data[$i];
      }

      if($i > $two_line && $i < $three_line)
      {
        $three[$i] = $data[$i];
      }

      if($i > $three_line && $i < $four_line)
      {
        $four[$i] = $data[$i];
      }
    }

    $one   = $this->getJinsuo(array_values($one));
    $two   = $this->getJinsuo(array_values($two));
    $three = $this->getJinsuo(array_values($three));
    $four  = $this->getJinsuo(array_values($four));


    return [$one, $two, $three, $four];
  }











  /*
   *切割成三维数组，每个小数字在一个数组里面
   *只适用四个数字一起的数组
   *@param 经过归一化处理的二值化数组
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





  public function isAllWith($data)
  {
    $result = 0;

    $total = array_sum($data);

    if(300 < $total && $total < 750)
    {
      return 8;
    }
    else if(750 < $total && $total < 1100 )
    {
      return 6;
    }
    else if($total > 1100)
    {
      return 0;
    }

    return $result;
  }

  public function isTenWith($data)
  {
    $result = 0;

    $total = array_sum($data);

    if(300 < $total && $total < 550)
    {
      return 9;
    }
    else
    {
      return 7;
    }

    return $result;
  }



  public function isOtherWith($data, $width)
  {
    $result = 0;

    $height = count($data);
    $width  = count($data[0]);
    $center  = ceil($width / 2);

    foreach($data as $k => $item)
    {
      $total = array_sum($item);

      if(5 > $total)
      {
        unset($data[$k]);
        $height--;
      }
    }

    $data = array_values($data);

    $result = [];

    foreach($data as $k => $item)
    {
      $tmp = array_keys(array_filter($item));
      $start = current($tmp);
      $end = end($tmp);

      $result[] = $start + $end;
    }

    $two_arr  = $result;

    array_shift($two_arr);
    array_shift($two_arr);
    array_pop($two_arr);
    array_pop($two_arr);
    $two_arr = array_values($two_arr);
    $len = count($two_arr);

    for($i = 0; $i < $len - 1; $i++)
    {
      $two = 2;

      if(empty($two_arr[$i]) || empty($two_arr[$i+1]))
      {
        continue;
      }

      if($two_arr[$i] > $two_arr[$i+1] && ($two_arr[$i] > ($two_arr[$i+1] + 3)))
      {
        $two = false;
        break;
      }
    }

    if(empty($two))
    {
      $four = 4;

      $four_arr  = $result;

      $center = floor(count($four_arr) / 2);

      $left = array_slice($four_arr, 0, $center);
      array_shift($left);
      array_shift($left);
      array_pop($left);
      array_pop($left);
      $left = array_values($left);
      $len = count($left);

      for($i = 0; $i < $len - 1; $i++)
      {
        if($left[$i] > $left[$i+1] && ($left[$i] > ($left[$i+1] + 3)))
        {
          $four = false;
          break;
        }
      }

      $right = array_slice($four_arr, $center, count($four_arr));
      array_shift($right);
      array_shift($right);
      array_pop($right);
      array_pop($right);
      $right = array_values($right);
      $len = count($right);

      for($i = 0; $i < $len - 1; $i++)
      {
        if($right[$i] < $right[$i+1] && ($right[$i] < ($right[$i+1] - 3)))
        {
          $four = false;
          break;
        }
      }
    }

    if(empty($two) && empty($four))
    {
      $three = 3;

      $three_arr = $result;

      $center = floor(count($three_arr) / 2);

      $left = array_slice($three_arr, 0, $center);
      array_shift($left);
      array_shift($left);
      array_pop($left);
      array_pop($left);
      $left = array_values($left);
      $len = count($left);

      for($i = 0; $i < $len - 1; $i++)
      {
        if($left[$i] < $left[$i+1] && ($left[$i] < ($left[$i+1] - 3)))
        {
          $three = false;
          break;
        }
      }

      $right = array_slice($three_arr, $center, count($three_arr));
      array_shift($right);
      array_shift($right);
      array_pop($right);
      array_pop($right);
      $right = array_values($right);
      $len = count($right);

      for($i = 0; $i < $len - 1; $i++)
      {
        if($right[$i] > $right[$i+1] && ($right[$i] > ($right[$i+1] + 3)))
        {
          $three = false;
          break;
        }
      }
    }

    if(empty($two) && empty($four) && empty($three))
    {
      $five = 5;

      $center = floor($len / 2);

      $five_arr = $result;

      $center = floor(count($three_arr) / 2);

      $left = array_slice($five_arr, 0, $center);
      array_shift($left);
      array_shift($left);
      array_pop($left);
      array_pop($left);
      $left = array_values($left);
      $len = count($left);

      for($i = 0; $i < $len - 1; $i++)
      {
        if($left[$i] < $left[$i+1] && ($left[$i] < ($left[$i+1] - 3)))
        {
          $five = false;
          break;
        }
      }

      $right = array_slice($five_arr, $center, count($five_arr));
      array_shift($right);
      array_shift($right);
      array_pop($right);
      array_pop($right);
      $right = array_values($right);
      $len = count($right);

      for($i = 0; $i < $len - 1; $i++)
      {
        if($right[$i] < $right[$i+1] && ($right[$i] < ($right[$i+1] - 3)))
        {
          $five = false;
          break;
        }
      }
    }


    if($two)
    {
      return $two;
    }
    else if($four)
    {
      return $four;
    }
    else if($three)
    {
      return $three;
    }
    else if($five)
    {
      return $five;
    }
  }


}



$model = new Identify('6.jpg');
// $model->printByGray();
$data = $model->getErzhi();
$data = $model->getJinsuo($data);

list($one, $two, $three, $four) = $model->getLine($data);

$model->printByGray($one);
$data = $model->cutSmall($one);

$res = [];
$result = [];


foreach($data as $item)
{
  $result[] = count($item[0]);

  rsort($result);
}


$all_width  = $result[0];
$all_width_left_offset = $all_width - 3;
$all_width_right_offset = $all_width + 3;

$four_width  = ceil($all_width / 4);
$four_width_left_offset = $four_width - 3;
$four_width_right_offset = $four_width + 3;

$ten_width  = $all_width - 10;
$ten_width_left_offset = $ten_width - 3;
$ten_width_right_offset = $ten_width + 3;

foreach($data as $s => $item)
{
  $result = [];

  $item = $data[12];


  $height = count($item);
  $width  = count($item[0]);

  foreach($item as $k => $vo)
  {
    $total = array_sum($vo);

    if(5 < $total)
    {
      $result[$k] = $total;
    }
    else
    {
      $height--;
    }
  }

  if($all_width == $width || ($all_width_left_offset <= $width && $all_width_right_offset >= $width))
  {
    echo $model->isAllWith($result) . '<br/>';
  }
  else if ($four_width == $width || ($four_width_left_offset <= $width && $four_width_right_offset >= $width))
  {
    echo 1 . '<br/>';
  }
  else if ($ten_width == $width || ($ten_width_left_offset <= $width && $ten_width_right_offset >= $width))
  {
    echo $model->isTenWith($result) . '<br/>';
  }
  else
  {
    echo $model->isOtherWith($item, $width) . '<br/>';
  }


}
