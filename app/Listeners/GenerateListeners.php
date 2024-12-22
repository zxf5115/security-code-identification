<?php

namespace App\Listeners;

use App\Events\GenerateEvent;
use Illuminate\Support\Facades\Redis;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Country;
use App\Models\Factory;
use App\Models\Fake;
use App\Models\Fake\Category;
use App\Jobs\GenerateQueue;

class GenerateListeners
{

  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
      //
  }

  /**
   * Handle the event.
   *
   * @param  GenerateEvent  $event
   * @return void
   */
  public function handle(GenerateEvent $event)
  {
    try
    {
      $model = $event->model;

      $id             = $model->id;
      $number         = $model->number;
      $country        = $model->country;
      $factory        = $model->factory;
      $category       = $model->category;
      $child_category = $model->child_category;
      $valid_time     = date('Y-m-d', strtotime($model->valid_time));

      $response = Country::firstOrCreate(['title' => $country]);
      $country = str_pad($response->id, 2, 0, STR_PAD_LEFT);

      $response = Factory::firstOrCreate(['title' => $factory]);
      $factory = str_pad($response->id, 2, 0, STR_PAD_LEFT);

      $response = Category::firstOrCreate(['parent_id' => 0, 'title' => $category]);
      $category = str_pad($response->id, 3, 0, STR_PAD_LEFT);

      $response = Category::firstOrCreate(['parent_id' => $response->id, 'title' => $child_category]);
      $child_category = str_pad($response->id, 2, 0, STR_PAD_LEFT);

      $data = [];

      $check_code = str_pad(mt_rand(1, 999999), 6, 0, STR_PAD_LEFT);

      $timestamp = time();

      for($i = 0; $i < $number; $i++)
      {
        $datetime = $timestamp + $i; // + $child_category + mt_rand(1, 86400);

        $tmp['import_id']      = $id;
        $tmp['country']        = $country;
        $tmp['factory']        = $factory;
        $tmp['category']       = $category;
        $tmp['check_code']     = $check_code;
        $tmp['child_category'] = $child_category;
        $tmp['valid_time']     = $valid_time;
        $tmp['time_code']      = date('ymdHis', $datetime);
        $tmp['password']       = Fake::setPassword();
        $tmp['create_time']    = $datetime;
        $tmp['update_time']    = $datetime;

        $data = json_encode($tmp);

        GenerateQueue::dispatch($data);
      }

      $model->status = 1;
      $model->save();
    }
    catch(\Exception $e)
    {
      \Log::error($e->getMessage());
    }
  }
}
