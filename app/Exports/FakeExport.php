<?php
namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


use App\Models\Fake;
use App\Models\Country;
use App\Models\Factory;
use App\Models\System\Config;
use App\Models\Fake\Category;

class FakeExport implements FromArray, WithHeadings, WithDrawings, ShouldAutoSize
{
  private $result = [];

  private $is_picture = 0;

  public function __construct($data)
  {
    $this->is_picture = $data['is_picture'];

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

    $this->result = $model->get()->toArray();
  }

  public function array(): array
  {
    $result = [];

    if($this->is_picture)
    {
      foreach($this->result as $key => $item)
      {
        $result[$key]['id']            = str_pad($item['id'], 10, 0, STR_PAD_LEFT);
        $result[$key]['security_code'] = $item['security_code'];
      }

      return $result;
    }

    foreach($this->result as $key => $item)
    {
      $result[$key]['id'] = $item['id'];

      $country        = intval($item['country']);
      $result[$key]['country'] = Country::find($country)->title ?? '';

      $factory        = intval($item['factory']);
      $result[$key]['factory'] = Factory::find($factory)->title ?? '';

      $category       = intval($item['category']);
      $result[$key]['category'] = Category::find($category)->title ?? '';

      $child_category = intval($item['child_category']);
      $result[$key]['child_category'] = Category::find($child_category)->title ?? '';

      $result[$key]['valid_time'] = $item['valid_time'];

      $result[$key]['security_code'] = '';

      $result[$key]['create_time'] = $item['create_time'];
    }

    return $result;
  }


  public function headings(): array
  {
    if($this->is_picture)
    {
      return ['商品编号', '安全码'];
    }

    return ['商品编号', '源产地', '厂家名称', '产品种类', '产品名称', '产品保质期', '防伪码', '生成时间'];
  }


  public function drawings()
  {
    $result = [];

    foreach($this->result as $k => $item)
    {
      ${'drawing'.$k} = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();

      $domain = Config::getValue('domain');

      $picture = str_replace($domain, '', $item['security_code']);

      ${'drawing'.$k}->setPath(public_path($picture));
      ${'drawing'.$k}->setHeight(90);

      $i = $k + 2;

      if($this->is_picture)
      {
        $position = 'B' . $i;
      }
      else
      {
        $position = 'G' . $i;
      }

      ${'drawing'.$k}->setCoordinates($position);

      ${'drawing'.$k}->setWorksheet($spreadsheet->getActiveSheet());
      // $result[] = ${'drawing'.$k};
    }
dd($result);
    return $result;
  }
}
