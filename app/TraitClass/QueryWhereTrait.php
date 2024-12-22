<?php
namespace App\Services;
/** 查询字段类Trait
 * Trait QueryWhereTrait
 */
trait  QueryWhereTrait
{
    public static $where = [];
    public $timeType = '';
    protected $timeFields = [];

    /**
     * 检索字段model_id的查询，whereBy这个是前缀，后面的才是查询字段
     * 参数：['model_id'=>1],则查询model_id=1的SQL语句
     * @param $value
     */
    public function whereByModelId($value)
    {
        $data = [
            'model_id' => [
                'type' => '=',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }
    public function whereByGroupType($value)
    {
        $data = [
            'group_type' => [
                'type' => '=',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }

    public function whereByModelType($value)
    {
        $data = [
            'model_type' => [
                'type' => '=',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }
    public function whereByWxMerchantId($value)
    {
        $data = [
            'wx_merchant_id' => [
                'type' => '=',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }
    public function whereByActiveId($value)
    {
        $data = [
            'active_id' => [
                'type' => '=',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }
    public function whereByVoteConfigId($value)
    {
        $data = [
            'vote_config_id' => [
                'type' => '=',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }
    public function whereByVoteThemeId($value)
    {
        $data = [
            'vote_theme_id' => [
                'type' => '=',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }

    /**
     * 检索status in
     * 参数:['status_in'=>[1,4]] ,查询status in [xx,xx]
     * @param $value
     */
    public function whereByStatusIn($value)
    {
        $data = [
            'status' => [
                'type' => 'in',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }
    public function whereById($value)
    {
        $data = [
            'id' => [
                'type' => '=',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }
    public function whereByPhone($value)
    {
        $data = [
            'phone' => [
                'type' => '=',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }

    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereByNameLikeQuery($value)
    {
        $data = [
            'name' => [
                'type' => 'like',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }

    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereByTitleLikeQuery($value)
    {
        $data = [
            'title' => [
                'type' => 'like',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }

    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereMarkLikeQuery($value)
    {
        $data = [
            'name' => [
                'type' => 'like',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }
    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereByNicknameLikeQuery($value)
    {

        $data = [
            'nickname' => [
                'type' => 'like',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }

    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereByUsernameLikeQuery($value)
    {

        $data = [
            'username' => [
                'type' => 'like',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }


    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereByDateLikeQuery($value)
    {
        $data = [
            'create_time' => [
                'type' => '>',
                'value' => strtotime($value)
            ]
        ];
        $this->addWhere($data);
    }

    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereByValidDateLikeQuery($value)
    {
        $data = [
            'valid_time' => [
                'type' => '>',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }


    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereByTitleRelevanceLikeQuery($value)
    {
        $category = \App\Models\Fake\Category::where('title', 'like', '%' . $value . '%')->get('id')->toArray();

        $category = array_column($category, 'id');

        $fake = \App\Models\Fake::whereIn('child_category', $category)->get('id')->toArray();

        $fake = array_column($fake, 'id');

        $data = [
            'fake_id' => [
                'type' => 'in',
                'value' => $fake
            ]
        ];

        $this->addWhere($data);
    }


    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereByFakeTitleLikeQuery($value)
    {
        $category = \App\Models\Fake\Category::where('title', 'like', '%' . $value . '%')->get('id')->toArray();

        $category = array_column($category, 'id');

        $data = [
            'child_category' => [
                'type' => 'in',
                'value' => $category
            ]
        ];

        $this->addWhere($data);
    }

    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereByFakeFactoryLikeQuery($value)
    {
        $factory = \App\Models\Factory::where('title', 'like', '%' . $value . '%')->get('id')->toArray();

        $factory = array_column($factory, 'id');

        $data = [
            'factory' => [
                'type' => 'in',
                'value' => $factory
            ]
        ];

        $this->addWhere($data);
    }


    /**
     * 检索name like SQL语句
     * ['name_like_query'=>'空气工作室']
     * @param $value
     */
    public function whereByFakeCategoryLikeQuery($value)
    {
        $category = \App\Models\Fake\Category::where('title', 'like', '%' . $value . '%')->get('id')->toArray();

        $category = array_column($category, 'id');

        $data = [
            'category' => [
                'type' => 'in',
                'value' => $category
            ]
        ];

        $this->addWhere($data);
    }


    /**
     * 前多少月份查询
     * @param int $value
     */
    public function whereByBeforeMonth(int $value)
    {
        $date = \App\Services\DateServices::getBeforeMonthToNow($value, 1);

        if (!empty($date)) {

            $this->setWhereTimeSql($date['start_at'], $date['end_at']);
        }
    }
    /**
     * 前或后多少天查询
     * @param int $value
     */
    public function whereByBeforeDay(int $value)
    {
        $date = \App\Services\DateServices::dayToNow($value, 1);

        if (!empty($date)) {

            $this->setWhereTimeSql($date['start_at'], $date['end_at']);
        }
    }

    //第几周查询
    public function whereByBeforeWeek(int $value)
    {
        $date = \App\Services\DateServices::dayToNow($value, 1);

        if (!empty($date)) {

            $this->setWhereTimeSql($date['start_at'], $date['end_at']);
        }
    }

    /**
     * 设置查询时间字段
     * @param $start_at
     * @param $end_at
     */
    public function setWhereTimeSql($start_at, $end_at)
    {
        $type = $this->timeType;
        $start_at = trim($start_at);
        $end_at = trim($end_at);
        if (in_array($type, $this->timeFields)) {
            $data = [
                $type => [
                    'type' => 'raw',
                    'value' => ["($type >= ? and $type <= ?) ", [$start_at, $end_at]]
                ]
            ];
        } else {
            $data = [
                'create_time' => [
                    'type' => 'raw',
                    'value' => ['(create_time>=? and create_time<=?) ', [$start_at, $end_at]]
                ]
            ];
        }
        $this->addWhere($data);
    }


    public function whereByIpAddressLikeQuery($value)
    {
        $data = [
            'ip_address' => [
                'type' => '=',
                'value' => $value
            ]
        ];
        $this->addWhere($data);
    }




    /**
     * 查询语句加入到搜索静态数组里面
     * @param $where
     * @return array
     */
    public function addWhere($where)
    {
        return self::$where = self::$where + $where;
    }

    /**
     * 完全移除搜索条件
     * @param array $param
     */
    public function unsetAllWhere($param = [])
    {
        self::$where = [];
    }

    /**
     * 移除某个查询语句数组
     * @param $key
     */
    public function unsetWhere($key)
    {
        if (array_key_exists($key, self::$where)) {
            unset(self::$where[$key]);
        }
    }
}
