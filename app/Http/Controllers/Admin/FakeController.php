<?php
namespace App\Http\Controllers\Admin;

use Excel;
use App\Models\Fake;
use App\Models\Country;
use App\Models\Factory;
use App\Models\System\Config;
use App\Models\Fake\Category;


use App\Jobs\GenerateQueue;
use Illuminate\Http\Request;

use App\Services\GenerateServices;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\TraitClass\ExportTrait;

class FakeController extends BaseDefaultController
{
  public $pageName='防伪码';

  use ExportTrait;


  public function orderByType()
  {
    return $this->rq->input('id', 'desc');
  }


  /**
   * JSON 列表输出项目设置
   * @param $item
   * @return mixed
   */
  public function apiJsonItem($item)
  {
    $item['edit_url'] = action($this->route['controller_name'] . '@edit', ['id' => $item->id]);
    $item['edit_post_url'] = action($this->route['controller_name'] . '@update', ['id' => $item->id]);

    $item->country = $item->countrys->title;
    $item->factory = $item->factorys->title;
    $item->category = $item->categorys->title;
    $item->child_category = $item->childCategorys->title;

    return $item;
  }



  public function export(Request $request)
  {
    $data = $request->all();

    if(empty($data['is_picture']))
    {
      $filename = '防伪码明细列表_' . time();
    }
    else
    {
      $filename = '防伪码列表_' . time();
    }

    $userBrowser = $_SERVER['HTTP_USER_AGENT'];

    if ( preg_match( '/MSIE/i', $userBrowser ) ) {

    $filename = urlencode($filename);

    }

    $filename = iconv('UTF-8', 'GBK//IGNORE', $filename);



    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $k = 1;

    $title = $this->getTitle($data['is_picture']);

    $ascii = 65;

    //设置第一行小标题
    foreach($title as $key => $item)
    {
      $letter = chr($ascii + $key);

      $sheet->setCellValue($letter . $k, $item);
    }

    // 设置样式
    $spreadsheet = $this->setFormat($spreadsheet);

    $result = $this->getData($data, $data['is_picture']);

    $k = 2;
    foreach ($result as $key => $value)
    {
      if($data['is_picture'])
      {
        $sheet->setCellValue('A' . $k, $value['id']);

        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getRowDimension($k)->setRowHeight(80);

        $domain = Config::getValue('domain');

        $picture = str_replace($domain, '', $value['security_code']);

        $drawing[$k] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing[$k]->setName('Logo');
        $drawing[$k]->setDescription('Logo');
        $drawing[$k]->setPath(public_path($picture));
        $drawing[$k]->setWidth(80);
        $drawing[$k]->setHeight(80);
        $drawing[$k]->setCoordinates('B'.$k);
        $drawing[$k]->setOffsetX(12);
        $drawing[$k]->setOffsetY(12);
        $drawing[$k]->setWorksheet($spreadsheet->getActiveSheet());
      }
      else
      {
        $country        = intval($value['country']);
        $country_name = Country::find($country)->title ?? '';

        $factory        = intval($value['factory']);
        $factory_name = Factory::find($factory)->title ?? '';

        $category       = intval($value['category']);
        $category_name = Category::find($category)->title ?? '';

        $child_category = intval($value['child_category']);
        $child_category_name = Category::find($child_category)->title ?? '';

        $sheet->setCellValue('A' . $k, $value['id']);
        $sheet->setCellValue('B' . $k, $country_name);
        $sheet->setCellValue('C' . $k, $factory_name);
        $sheet->setCellValue('D' . $k, $category_name);
        $sheet->setCellValue('E' . $k, $child_category_name);
        $sheet->setCellValue('F' . $k, $value['valid_time']);
        $sheet->setCellValue('H' . $k, $value['create_time']);

        $sheet->getColumnDimension('G')->setWidth(40);
        $sheet->getRowDimension($k)->setRowHeight(80);

        $domain = Config::getValue('domain');

        $picture = str_replace($domain, '', $value['security_code']);

        $drawing[$k] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing[$k]->setName('Logo');
        $drawing[$k]->setDescription('Logo');
        $drawing[$k]->setPath(public_path($picture));
        $drawing[$k]->setWidth(80);
        $drawing[$k]->setHeight(80);
        $drawing[$k]->setCoordinates('G'.$k);
        $drawing[$k]->setOffsetX(12);
        $drawing[$k]->setOffsetY(12);
        $drawing[$k]->setWorksheet($spreadsheet->getActiveSheet());
      }

      $k++;
    }

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
    header('Cache-Control: max-age=0');
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
    $writer->save('php://output');
  }




  public function setModel()
  {
    return $this->model=new Fake();
  }


  /**
   * 表单验证规则
   * @param string $id
   * @return array
   */
  public function checkRule($id = '')
  {
    if (!$id) {
      return [
        'title' => 'required',
        'content' => 'required',
        'fouder' => 'required',
      ];
    }

    return [
      'title' => 'required',
      'content' => 'required',
      'fouder' => 'required',
    ];
  }

  /**
   * 设置检验对应字段的名字输出
   * @return array
   */
  public function checkRuleField(){
    $messages = [
      'title' => '标题',
      'content'    =>'内容',
      'fouder'    =>'发布人'
    ];

    return $messages;
  }


  /**
   * 创建/更新共享数据
   * @param string $id
   * @return array
   */
  public function createEditData($id='')
  {
    $categorys = $this->getCategory()->toArray();

    $categorys = $this->tree($categorys);

    return ['categorys' => $categorys];
  }


  public function getCategory()
  {
    return Category::get();
  }
}
