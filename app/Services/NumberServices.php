<?php
namespace App\Services;

/**
 * 图片识别
 */
class NumberServices
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 获取偏移量
   * ------------------------------------------
   *
   * 获取偏移量
   *
   * @param [type] $width 最大宽度
   * @return [type]
   */
  public static function getOffset($width)
  {
    if($width > 700 && $width < 1200)
    {
      $offset = 100;
    }

    else if($width > 350 && $width < 701)
    {
      $offset = 50;
    }
    else if($width > 110 && $width < 351)
    {
      $offset = 25;
    }
    else if($width > 95 && $width < 110)
    {
      $offset = 9;
    }
    else if($width > 80 && $width < 96)
    {
      $offset = 8;
    }
    else if($width > 65 && $width < 81)
    {
      $offset = 7;
    }
    else if($width > 50 && $width < 66)
    {
      $offset = 6;
    }
    else if($width > 35 && $width < 51)
    {
      $offset = 5;
    }
    else if($width > 25 && $width < 36)
    {
      $offset = 4;
    }
    else if($width > 15 && $width < 26)
    {
      $offset = 3;
    }
    else
    {
      $offset = 2;
    }

    return $offset;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 识别 0
   * ------------------------------------------
   *
   * 识别 0
   *
   * @param [type] $data 元素数组
   * @param [type] $width 最大宽度
   * @return boolean
   */
  public static function isZero($data, $width)
  {
    $data = self::clearEmptyValue($data);

    $data = array_values($data);
    $total = count($data);

    $interval = floor($total / 3);
    $one      = $interval * 1;
    $two      = $interval * 2;
    $three    = $interval * 3;

    $one_status   = self::allValue($data, 0, $interval, $width);
    $two_status   = self::allValue($data, $one, $interval, $width);
    $three_status = self::allValue($data, $two, $interval, $width);
// var_dump($one_status);
// var_dump($two_status);
// var_dump($three_status);
// exit;
    if($one_status && $two_status && $three_status)
    {
      return true;
    }

    return false;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 识别 1
   * ------------------------------------------
   *
   * 识别 1
   *
   * @param [type] $data 元素数组
   * @param [type] $width 最大宽度
   * @return boolean
   */
  public static function isOne($data, $width)
  {
    $data = self::clearEmptyValue($data);

    $data = array_values($data);
    $total = count($data);
    $result = [];
    $respone = false;
// dd($data);
    $offset = self::getOffset($width);

    for($i = 0; $i < $total - 1; $i++)
    {
      $left_width = array_sum($data[$i]);
      $right_width = array_sum($data[$i+1]);

      if($left_width == $right_width || ($left_width - $offset) <= $right_width || ($left_width + $offset) >= $right_width)
      {
        $line_width = $left_width * 3.5;

        if($line_width < $width)
        {
          $result[] = 1;
        }
      }
    }

    $result_total = count($result);

    if($result_total != 0 && ($result_total == $total || (($result_total - 4) <= $total && ($result_total + 4) >= $total)))
    {
      $respone = true;
    }

    return $respone;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 识别 2
   * ------------------------------------------
   *
   * 识别 2
   *
   * @param [type] $data 元素数组
   * @param [type] $width 最大宽度
   * @return boolean
   */
  public static function isTwo($data, $width)
  {
    $data = self::clearEmptyValue($data);

    $data = array_values($data);
    $total = count($data);

    $interval = floor($total / 5);
    $one      = $interval * 1;
    $two      = $interval * 2;
    $three    = $interval * 3;
    $four     = $interval * 4;
    $five     = $interval * 5;

    $one_status   = self::leftHalfValue($data, 0, $interval);
    $two_status   = self::includeLeftHalfValue($data, $one, $interval);
    $three_status = self::includeAllValue($data, $two, $interval);
    $four_status  = self::rightHalfValue($data, $three, $interval);
    $five_status  = self::rightHalfValue($data, $four, $interval);
// var_dump($one_status);
// var_dump($two_status);
// var_dump($three_status);
// var_dump($four_status);
// var_dump($five_status);
// exit;
    if($one_status && $two_status && $three_status && $four_status && $five_status)
    {
      return true;
    }

    return false;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 识别 3
   * ------------------------------------------
   *
   * 识别 3
   *
   * @param [type] $data 元素数组
   * @param [type] $width 最大宽度
   * @return boolean
   */
  public static function isThree($data, $width)
  {
    $data = self::clearEmptyValue($data);

    $data = array_values($data);

    $total = count($data);

    $interval = floor($total / 5);
    $one      = $interval * 1;
    $two      = $interval * 2;
    $three    = $interval * 3;
    $four     = $interval * 4;
    $five     = $interval * 5;

    $one_status   = self::includeAllValue($data, 0, $interval);
    $two_status   = self::includeLeftHalfValue($data, $one, $interval);
    $three_status = self::leftHalfValue($data, $two, $interval);
    $four_status  = self::includeLeftHalfValue($data, $three, $interval);
    $five_status  = self::includeAllValue($data, $four, $interval);
// var_dump($one_status);
// var_dump($two_status);
// var_dump($three_status);
// var_dump($four_status);
// var_dump($five_status);
// exit;
    if($one_status && $two_status && $three_status && $four_status && $five_status)
    {
      return true;
    }

    return false;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 识别 4
   * ------------------------------------------
   *
   * 识别 4
   *
   * @param [type] $data 元素数组
   * @param [type] $width 最大宽度
   * @return boolean
   */
  public static function isFour($data, $width)
  {
    $data = self::clearEmptyValue($data);

    $data = array_values($data);
    $total = count($data);

    $interval = floor($total / 5);
    $one      = $interval * 1;
    $two      = $interval * 2;
    $three    = $interval * 3;
    $four    = $interval * 4;
    $five    = $interval * 5;

    $one_status   = self::leftHalfValue($data, 0, $interval);
    $two_status   = self::includeLeftHalfValue($data, $one, $interval);
    $three_status = self::includeAllValue($data, $two, $interval);
    $four_status  = self::includeLeftHalfValue($data, $three, $interval);
    $five_status  = self::leftHalfValue($data, $four, $interval);
// var_dump($one_status);
// var_dump($two_status);
// var_dump($three_status);
// var_dump($four_status);
// var_dump($five_status);
// exit;
    if($one_status && $two_status && $three_status && $four_status && $five_status)
    {
      return true;
    }

    return false;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 识别 5
   * ------------------------------------------
   *
   * 识别 5
   *
   * @param [type] $data 元素数组
   * @param [type] $width 最大宽度
   * @return boolean
   */
  public static function isFive($data, $width)
  {
    $data = self::clearEmptyValue($data);

    $data = array_values($data);
    $total = count($data);

    $interval = floor($total / 4);
    $one      = $interval * 1;
    $two      = $interval * 2;
    $three    = $interval * 3;
    $four     = $interval * 4;

    $one_status   = self::includeAllValue($data, 0, $interval);
    $two_status   = self::includeLeftHalfValue($data, $one, $interval);
    $three_status = self::includeAllValue($data, $two, $interval);
    $four_status = self::includeLeftHalfValue($data, $three, $interval);
// var_dump($one_status);
// var_dump($two_status);
// var_dump($three_status);
// var_dump($four_status);
// exit;
    if($one_status && $two_status && $three_status && $four_status)
    {
      return true;
    }

    return false;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 识别 6
   * ------------------------------------------
   *
   * 识别 6
   *
   * @param [type] $data 元素数组
   * @param [type] $width 最大宽度
   * @return boolean
   */
  public static function isSix($data, $width)
  {
    $data = self::clearEmptyValue($data);

    $data = array_values($data);
    $total = count($data);

    $interval = floor($total / 5);
    $one      = $interval * 1;
    $two      = $interval * 2;
    $three    = $interval * 3;
    $four     = $interval * 4;
    $five     = $interval * 5;

    $one_status   = self::includeAllValue($data, 0, $interval);
    $two_status   = self::centerEmptyValue($data, $one, $interval);
    $three_status = self::centerEmptyValue($data, $two, $interval);
    $four_status  = self::centerEmptyValue($data, $three, $interval);
    $five_status  = self::includeAllValue($data, $four, $interval);
// var_dump($one_status);
// var_dump($two_status);
// var_dump($three_status);
// var_dump($four_status);
// var_dump($five_status);
// exit;
    if($one_status && $two_status && $three_status && $four_status && $five_status)
    {
      return true;
    }

    return false;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 识别 7
   * ------------------------------------------
   *
   * 识别 7
   *
   * @param [type] $data 元素数组
   * @param [type] $width 最大宽度
   * @return boolean
   */
  public static function isServer($data, $width)
  {
    $data = self::clearEmptyValue($data);

    $data = array_values($data);
    $total = count($data);

    $interval = floor($total / 5);
    $one      = $interval * 1;
    $two      = $interval * 2;
    $three    = $interval * 3;
    $four     = $interval * 4;
    $five     = $interval * 5;

    $one_status   = self::leftHalfValue($data, 0, $interval);
    $two_status   = self::includeLeftHalfValue($data, $one, $interval);
    $three_status = self::includeAllValue($data, $two, $interval);
    $four_status  = self::centerEmptyValue($data, $three, $interval);
    $five_status  = self::includeAllValue($data, $four, $interval);
// var_dump($one_status);
// var_dump($two_status);
// var_dump($three_status);
// var_dump($four_status);
// var_dump($five_status);
// exit;
    if($one_status && $two_status && $three_status && $four_status && $five_status)
    {
      return true;
    }

    return false;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 识别 8
   * ------------------------------------------
   *
   * 识别 8
   *
   * @param [type] $data 元素数组
   * @param [type] $width 最大宽度
   * @return boolean
   */
  public static function isEight($data, $width)
  {
    $data = self::clearEmptyValue($data);

    $data = array_values($data);
    $total = count($data);

    $interval = floor($total / 3);
    $one      = $interval * 1;
    $two      = $interval * 2;
    $three    = $interval * 3;

    $one_status   = self::includeAllValue($data, 0, $interval);
    $two_status   = self::rightHalfValue($data, $one, $interval);
    $three_status = self::rightHalfValue($data, $two, $interval);

    if($one_status && $two_status && $three_status)
    {
      return true;
    }

    return false;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-13
   * ------------------------------------------
   * 识别 9
   * ------------------------------------------
   *
   * 识别 9
   *
   * @param [type] $data 元素数组
   * @param [type] $width 最大宽度
   * @return boolean
   */
  public static function isNine($data, $width)
  {
    $data = self::clearEmptyValue($data);

    $data = array_values($data);
    $total = count($data);

    $interval = floor($total / 4);
    $one      = $interval * 1;
    $two      = $interval * 2;
    $three    = $interval * 3;
    $four     = $interval * 4;

    $one_status   = self::centerHalfValue($data, 0, $interval);
    $two_status   = self::centerHalfValue($data, $one, $interval);
    $three_status = self::centerHalfValue($data, $two, $interval);
    $four_status  = self::includeAllValue($data, $three, $interval);
// var_dump($one_status);
// var_dump($two_status);
// var_dump($three_status);
// var_dump($four_status);
// exit;
    if($one_status && $two_status && $three_status && $four_status)
    {
      return true;
    }

    return false;
  }








  // -----------------------------------------------------------

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-28
   * ------------------------------------------
   * 是否从左开始最大只占一半
   * ------------------------------------------
   *
   * 是否从左开始最大只占一半
   *
   * @param [type] $data 数据
   * @param [type] $number 那块内容，上中下
   * @param [type] $total 平均值
   * @return [type]
   */
  private static function leftHalfValue($data, $number, $interval)
  {
    $data = array_splice($data, $number, $interval);

    $status = [];

    foreach($data as $k => $item)
    {
      $total = count($item);
      $sum = array_sum($item);

      $offset = self::getOffset($total);

      if($total > $sum + $offset)
      {
        $value = array_filter($item);
        $keys = array_keys($value);
        $start = array_shift($keys);
        $end = array_pop($keys);

        if(($start == 0 || $start - $offset <= 0) && $end < $total && ($end + $offset * 2) <= $total)
        {
          $status[] = 1;
        }
        else
        {
          $status[] = 2;
        }
      }
      else
      {
        return false;
      }
    }

    $offset = self::getOffset(count($status));

    $respone = array_count_values($status);

    if(!empty($respone[1]) && ($respone[1] * 2) > $interval)
    {
      return true;
    }

    return false;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-28
   * ------------------------------------------
   * 包含是否从左开始最大只占一半
   * ------------------------------------------
   *
   * 包含是否从左开始最大只占一半
   *
   * @param [type] $data 数据
   * @param [type] $number 那块内容，上中下
   * @param [type] $total 平均值
   * @return [type]
   */
  private static function includeLeftHalfValue($data, $number, $interval)
  {
    $data = array_splice($data, $number, $interval);

    $status = [];

    foreach($data as $k => $item)
    {
      $total = count($item);
      $sum = array_sum($item);

      $offset = self::getOffset($total);

      if($total > $sum + $offset)
      {
        $value = array_filter($item);
        $keys = array_keys($value);
        $start = array_shift($keys);
        $end = array_pop($keys);

        if(($start == 0 || $start - $offset <= 0) && $end < $total && ($end + $offset * 2) <= $total)
        {
          return true;
        }
      }
    }

    return false;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-28
   * ------------------------------------------
   * 是否从左开始最大只占一半
   * ------------------------------------------
   *
   * 是否从左开始最大只占一半
   *
   * @param [type] $data 数据
   * @param [type] $number 那块内容，上中下
   * @param [type] $total 平均值
   * @return [type]
   */
  private static function rightHalfValue($data, $number, $interval)
  {
    $data = array_splice($data, $number, $interval);

    foreach($data as $item)
    {
      $total = count($item);
      $sum = array_sum($item);

      $offset = self::getOffset($total);

      if($total > $sum + $offset)
      {
        $value = array_filter($item);
        $keys = array_keys($value);
        $start = array_shift($keys);
        $end = array_pop($keys);

        if(($end == $total || $end + $offset > $total) && $start > 0 && ($start - $offset * 2) >= 0)
        {
          return true;
        }
      }
    }

    return false;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-28
   * ------------------------------------------
   * 是否从中间开始最大只占一半
   * ------------------------------------------
   *
   * 是否从中间开始最大只占一半
   *
   * @param [type] $data 数据
   * @param [type] $number 那块内容，上中下
   * @param [type] $total 平均值
   * @return [type]
   */
  private static function centerHalfValue($data, $number, $interval)
  {
    $data = array_splice($data, $number, $interval);

    $status = [];

    foreach($data as $item)
    {
      $total = count($item);
      $sum = array_sum($item);

      $offset = self::getOffset($total);

      if($sum < $offset)
      {
        $interval--;

        continue;
      }

      if($total > $sum + $offset)
      {
        $value = array_filter($item);
        $keys = array_keys($value);
        $start = array_shift($keys);
        $end = array_pop($keys);
// echo $start;
// echo '<br/>';
// echo $end;
// echo '<br/>';
// echo $total;
// echo '<br/>';
// echo $offset;
// exit;
        if(($start > 0 && $start - $offset > 0) && $end < $total && ($end + $offset) < $total)
        {
          $status[] = 1;
        }
        else
        {
          $status[] = 2;
        }
      }
    }

    $respone = array_count_values($status);

    if(!empty($respone[1]) && ($respone[1] * 2) > $interval)
    {
      return true;
    }

    return false;
  }



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-28
   * ------------------------------------------
   * 是否从中间开始有一部分空值
   * ------------------------------------------
   *
   * 是否从中间开始有一部分空值
   *
   * @param [type] $data 数据
   * @param [type] $number 那块内容，上中下
   * @param [type] $total 平均值
   * @return [type]
   */
  private static function centerEmptyValue($data, $number, $interval)
  {
    $data = array_splice($data, $number, $interval);

    $status = [];

    foreach($data as $item)
    {
      $total = count($item);
      $sum = array_sum($item);

      $offset = self::getOffset($total);

      if($total > $sum + $offset)
      {
        $value = array_filter($item);
        $keys = array_keys($value);

        $end = end($keys);

        $center = floor($total / 2);

        $result = [];

        for($i = $center - 2; $i < $center + 2; $i++)
        {
          if(in_array($i, $keys))
          {
            $result[] = 2;
          }
          else
          {
            if($end + $offset > $total)
            {
              $result[] = 1;
            }
          }
        }

        if(in_array(1, $result))
        {
          return true;
        }
      }
    }

    return false;
  }





  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-28
   * ------------------------------------------
   * 包含全等值
   * ------------------------------------------
   *
   * 包含全等值
   *
   * @param [type] $data 数据
   * @param [type] $number 那块内容，上中下
   * @param [type] $total 平均值
   * @return [type]
   */
  private static function includeAllValue($data, $number, $interval)
  {
    $data = array_splice($data, $number, $interval);

    $result = [];

    foreach($data as $item)
    {
      $total = count($item);
      $sum = array_sum($item);

      $offset = self::getOffset($total);

      if($total == $sum || $total <  $sum + $offset * 2)
      {
        return true;
      }
    }

    return false;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-05-28
   * ------------------------------------------
   * 是否是全宽
   * ------------------------------------------
   *
   * 是否是全宽
   *
   * @param [type] $data 数据
   * @param [type] $number 那块内容，上中下
   * @param [type] $total 平均值
   * @return [type]
   */
  private static function allValue($data, $number, $interval, $all_width = 0)
  {
    $data = array_splice($data, $number, $interval);

    $result = [];

    foreach($data as $item)
    {
      $total = count($item);
      $sum = array_sum($item);

      $offset = self::getOffset($total);

      if($sum < $offset)
      {
        $interval--;

        continue;
      }

      $value = array_filter($item);
      $keys = array_keys($value);

      if(($total == $sum || $total <  $sum + $offset) && ($all_width && $total > $all_width / 2))
      {
        $result[] = 1;
      }
      else
      {
        $result[] = 2;
      }
    }

    $result = array_count_values($result);

    if(!empty($result[1]) && $result[1] * 2 > $interval)
    {
      return true;
    }

    return false;
  }




  private static function clearEmptyValue($data)
  {
    $result = [];

    foreach($data as $k => $item)
    {
      $total = count($item);
      $sum   = array_sum($item);

      $offset = self::getOffset($total);

      if($sum > $offset)
      {
        $result[$k] = $item;
      }
    }

    return $result;
  }
}
