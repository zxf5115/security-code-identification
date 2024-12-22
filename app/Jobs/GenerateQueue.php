<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Fake;
use App\Models\System\Config;
use App\Services\GenerateServices;

class GenerateQueue implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * The number of times the job may be attempted.
   *
   * @var int
   */
  public $tries = 5;


  /**
   * The number of seconds the job can run before timing out.
   *
   * @var int
   */
  public $timeout = 120;


  public $data;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    try
    {
      $data = json_decode($this->data, true);

      $model = new Fake();

      $model->insert($data);

      $id = DB::getPdo()->lastInsertId();

      $data['id'] = $id;
      $path = GenerateServices::generatePicture($data);

      $domain = Config::getValue('domain');

      $model = Fake::find($id);
      $model->security_code = $domain . DIRECTORY_SEPARATOR . $path;
      $model->save();

      return true;
    }
    catch(\Exception $e)
    {
      \Log::error($e->getMessage());
    }
  }

}
