<?php
namespace App\TraitClass;

use App\Models\Fake;
use App\Models\Country;
use App\Models\Factory;
use App\Models\System\Config;
use App\Models\Fake\Category;

trait ExportTrait
{
  public function getTitle($is_picture = false)
  {
    if($is_picture)
    {
      return ['商品编号', '安全码'];
    }

    return ['商品编号', '源产地', '厂家名称', '产品种类', '产品名称', '产品保质期', '防伪码', '生成时间'];
  }


  public function setFormat($spreadsheet, $is_picture = false)
  {
    if($is_picture)
    {
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);

      // 垂直居中
      $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
      $spreadsheet->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

      return $spreadsheet;
    }


    // 设置个表格宽度
    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(40);
    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);

    // 垂直居中
    $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('B')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('C')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('D')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('E')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('F')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('G')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('H')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    return $spreadsheet;
  }



  public function getData($data, $is_picture = false)
  {
    $model = new Fake();

    if(!empty($data['title']))
    {
      $ids = Category::where('title', 'like', '%'.$data['title'].'%')->get('id')->toArray();
      $ids = array_column($ids, 'id');

      $model = $model->whereIn('child_category', $ids);
    }

    if(!empty($data['factory']))
    {
      $ids = Factory::where('title', 'like', '%'.$data['factory'].'%')->get('id')->toArray();

      $ids = array_column($ids, 'id');

      $model = $model->whereIn('factory', $ids);
    }

    if(!empty($data['category']))
    {
      $ids = Category::where('title', 'like', '%'.$data['category'].'%')->get('id')->toArray();
      $ids = array_column($ids, 'id');

      $model = $model->whereIn('category', $ids);
    }

    if(!empty($data['valid_date']))
    {
      $model = $model->where('valid_time', '>=', $data['valid_date']);
    }

    return $model->get()->toArray();
  }
}
