<?php
namespace App\TraitClass;

use App\Services\SearchServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

trait ModelCurlTrait
{
    use ApiTrait, CheckFormTrait;
    public $checkErrorSuffix = "<br/>";//输出验证表单的后缀连接符
    public $model;//模型
    public $timeType = '';//搜索字段时间字段/类型
    public $rq;//保存/创建的请求$request
    public $modelSaveMsg = [];//报错模型之前是否存在错误
    public $modelInsertId;//最后插入的ID
    public $pageName = '';//页面名字
    public $saveOutStr = '';//保存/创建的自定义输出字符串


    /**
     * 创建和编辑公用数据
     * @return array
     */
    public function createEditData($show = '')
    {
        return [];
    }

    /**
     * POST过来的数据
     * @param string $id 如果更新，则存在
     * @return mixed
     */
    protected function postData($id = '')
    {
        return $this->rq->all();
    }

    /**
     * 页面名字
     */
    public function pageName()
    {
        $this->shareView(['page_name' => $this->pageName]);
        return $this->pageName;
    }


    /**
     * 保存模型之前需要操作的事情
     * @param $model
     * @param string $id
     * @return mixed
     */
    public function saveModelAddData($model, $id = '')
    {
        return $model;
    }

    /**
     * 创建/更新之前的操作
     * @param $model
     * @param $request
     * @param string $id ID存在表示更新
     */
    protected function beforeSave($model, $id = '')
    {
    }

    /**
     * 添加编辑成功之后要执行的方法
     * @param $request
     * @param $model
     * @param string $id
     */
    protected function afterSave($model, $id = '')
    {
    }

    /**
     * 如果是事务提交，事务提交之后的操作的事情
     * @param $model
     * @param string $id
     */
    protected function beginAfterSave($model, $id = '')
    {

    }


    /**
     * 是否开启事务
     * @return bool 真表示开启
     */
    protected function beginDb($data, $id = '')
    {
        return isset($data['begin_db']) ? $data['begin_db'] : 0;
    }

    /**
     * 取得当前的模型的字段列表
     * @param $model
     * @return mixed
     */
    protected function getField()
    {
        return $this->getModel()->getModelField();

    }

    /**
     * 设置创建数据键值对
     * @param $obj
     * @param $data
     * @return mixed
     */
    protected function setDbKeyValue($obj, $data)
    {

        $fileds = $this->getField();

        foreach ($data as $field => $v) {
            if (in_array($field, $fileds)) {
                $v = is_null($v) ? '' : $v;
                $obj->$field = trim($v);
            }
        }

        return $obj;
    }

    /**
     * 添加提交数据
     */
    public function addPostData($model)
    {
        return $model;
    }

    /**
     * 创建和更新操作
     * @param $request
     * @param $model 操作类，创建,更新对应的类,
     * @param string $id 创建为空，更新为当前的ID
     * @return array|\Illuminate\Http\JsonResponse
     */
    protected function saveData($request, $model, $id = '')
    {
        $this->rq = $request;
        $error = $this->checkForm($request->all(), $this->checkRule($id), $this->checkRuleMsg(), $this->checkRuleField());
        if (count($error) > 0) {
            return $this->checkFormErrorFormat($error);
        };
        //附加检验
        $extend_check = $this->extendValidate($model, $id);
        if (is_array($extend_check)) {
            return response()->json($extend_check);
        }
        //设置请求参数
        $data = $this->postData($id);

        //参数赋值给模型
        $model = $this->setDbKeyValue($model, $data);
        $model = $this->addPostData($model);
        //是否开启事务
        $begin = $this->beginDb($data);
        //更新/添加之前要操作的事
        $this->beforeSave($model, $id);
        $model = $this->saveModelAddData($model, $id);
        //检测之前是否有问题
        if (count($this->modelSaveMsg) > 0) {
            return $this->returnErrorApi($this->modelSaveMsg['msg'], [], $this->modelSaveMsg['code']);
        }
        //$begin=1表示开启事务操作
        if ($begin != 0) {
            DB::beginTransaction();
            $result = $model->save();
            //插入/更新最后ID
            $result ? $this->modelInsertId = $model->id : '';
            //事务的操作，之后的需要返回真才能够完成，否则失败
            $after_result = $this->afterSave($model, $id);
            if ($result && $after_result) {
                DB::commit();
                $this->beginAfterSave($model, $id);
            } else {
                DB::rollback();
            }
        } else {
            //非事务操作
            $result = $model->save();
            $result ? $this->modelInsertId = $model->id : '';
            $this->afterSave($model, $id);
        }
        //返回信息
        return $this->saveMessage($result, $id);
    }

    /**
     * 全局创建和更新操作返回消息
     * @param $result
     * @param $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveMessage($result, $id = '')
    {
        $request = $this->rq;
        $type = $id ? '更新' : '创建';
        if ($request->method() == 'DELETE') {
            $type = '删除';
        }
        $msg_type = $result ? '成功' : '失败';
        $msg_str = $this->pageName() . $type . $msg_type;

        if($id)
            $msg_str = $this->pageName() . ' ['. $id .'] ' . $type . $msg_type;

        if ($result) {
            $this->allAfterEvent();

            self::behavior($msg_str);
        }
        if ($request->ajax() || $request->wantsJson()) {
            return $this->returnApi($result ? 200 : 1, $this->saveOutStr ?: $msg_str);
        }
    }


    /**
     * 设置模型
     * @param $model
     * @return mixed
     */
    public function setModel()
    {
        return $this->model;
    }

    /**
     * 取得table 名字
     * @return string
     */
    protected function getTable()
    {
        if (gettype($this->getModel()) != 'object') {
            $table = '';
        } else {
            $table = $this->getModel()->getTable();
        }
        $share_view['table_name'] = $table;

        $this->shareView($share_view);
        return $table;
    }

    /**
     * 取得模型
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * 搜索模型实例化
     * @param $data 搜索参数
     * @return mixed 然后操作的模型
     */
    public function getSearchModel($data)
    {
        $model = new SearchServices($this->getModel(), $data, $this->timeType);
        return $model->returnModel();
    }

    /**
     * 检查验证规则
     * @param string $id id不为空表示更新的规则，可用这个判断
     * @return array
     */
    protected function checkRule($id = '')
    {
        return [];
    }

    /**
     * 设置表单验证键值对不通过输出的
     * @return array
     */
    public function checkRuleMsg()
    {
        $messages = [
        ];
        return $messages;
    }

    /**
     * 设置表单验证的字段值对应名字
     * @return array
     */
    public function checkRuleField()
    {
        $messages = [
        ];
        return $messages;
    }

    /**
     * 附加验证器
     * @param $model 模型
     * @param $id 更新是的对应ID
     * @return bool
     * 返回数组的时候，表示有错误
     */
    protected function extendValidate($model = '', $id = '')
    {
        return true;
    }


    /**
     * 共享视图变量
     * @return mixed
     */
    public function shareView($data)
    {
        return view()->share($data);
    }

    /**
     * 批量操作
     * @return mixed
     */
    public function allCreate(Request $request)
    {

        return $this->display($this->createEditData());
    }

    /**
     * 批量写入数据的数据
     * @param Request $request
     */
    public function allCreateSetData(Request $request)
    {
    }

    /**
     * 批量操作方法
     * @param Request $request
     * @return array
     */
    public function allCreatePost(Request $request)
    {
        $this->rq = $request;
        //检验表单
        $error = $this->allCreateCheckForm();
        if (count($error) > 0) {
            return $this->checkFormErrorFormat($error);
        };
        //附加检验
        $extend_check = $this->allCreateExtendValidate();
        if (is_array($extend_check)) {
            return response()->json($extend_check);
        }
        //写入
        $post_data = $this->allCreateSetData($request);
        if (empty($post_data)) {
            return $this->returnErrorApi('缺少参数');
        }
        $r = $this->getModel()->insert($post_data);
        if ($r) {
            $this->afterAllCreateEvent();//批量添加成功之后的事件

            self::behavior('批量插入成功');

            $this->allAfterEvent();
            return $this->returnOkApi($this->pageName . '批量插入成功');
        }

        return $this->returnErrorApi($this->pageName . '批量插入失败');
    }

    /**
     * 批量操作表单验证
     * @return array
     */
    protected function allCreateCheckForm()
    {
        //检验表单
        return $this->checkForm($this->rq->all(), $this->checkRule(''), $this->checkRuleMsg(), $this->checkRuleField());

    }


    /**
     * 提交表格导入
     */
    public function importPost(Request $request)
    {
        $is_del = $request->input('del');

        if(false !== strpos($request->input('excel'), 'http'))
        {
            $url = $request->input('excel');

            $loacl = $_SERVER['HTTP_ORIGIN'] ?? $_SERVER['APP_URL'] .':'.$_SERVER['SERVER_PORT'];

            $file = str_replace($loacl, '', $url);

            $file = linux_path(public_path()) . $file;
        }
        else
        {
            $file = linux_path(public_path()) . ($request->input('excel'));
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

        $worksheet = $spreadsheet->getActiveSheet();

        $sheetdata = $worksheet->toArray();


        //进行批量插入
        if (empty($sheetdata)) {
            return $this->returnErrorApi('没有数据');
        }
        $title_data = $sheetdata[0];

        if(!empty($this->model->sheet))
        {
            $sheet = $this->model->sheet;

            foreach($sheet as $key => $item)
            {
                $k = array_search($item, $title_data);
                if(false === $k)
                    continue;

                $title_data[$k] = $key;
            }
        }

        $insert_data = [];
        if (!isset($sheetdata[1])) {
            return $this->returnErrorApi('没有数据');
        }
        $data = $sheetdata;
        unset($data[0]);
        try {
            foreach ($data as $k => $v) {
                foreach ($v as $sk => $sv) {

                    if(empty($sv))
                    {
                        $label = empty($sheetdata[0][$sk]) ? '未知变量' : $sheetdata[0][$sk];
                        $messages = $label . ' 不能为空. ';
                        return $this->returnErrorApi($messages);
                    }

                    $insert_data[$k][$title_data[$sk]] = $sv;
                    $insert_data[$k]['create_time'] = time();
                    $insert_data[$k]['update_time'] = time();
                }
            }

        } catch (\Exception $exception) {
            return $this->returnErrorApi('数据异常');
        }
        if (empty($insert_data)) {
            return $this->returnErrorApi('没有数据插入');
        }
        if ($is_del) {

            $this->model->where('id', '!=', 0)->delete();
        }

        try {
            $r = $this->model->insert($insert_data);
            if ($r) {
                $id = DB::getPdo()->lastInsertId();

                $this->allAfterEvent();

                self::behavior($this->pageName . ' ['. $id .'] ' . '导入成功');

                return $this->returnOkApi('导入成功');

            }

            return $this->returnErrorApi('导入失败');

        } catch (\Exception $exception) {
            return $this->returnErrorApi('数据异常,请重新上传表格数据或自检' . $exception->getMessage());
        }

    }

    /**
     * 生成导入模板
     * @param Request $request
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function importTpl(Request $request)
    {
        //取得字段，
        $files = $this->getField();

        // 根据model中 excel 去掉不必要字段
        if(!empty($this->model->excel))
        {
            $del = $this->model->excel;

            foreach($files as $key => $item)
            {
                if(false !== in_array($item, $del))
                    unset($files[$key]);
            }
        }

        if(!empty($this->model->add_excel))
        {
            $add_excel = $this->model->add_excel;
            $files = array_merge($files, $add_excel);
        }

        if(!empty($this->model->sheet))
        {
            $sheet = $this->model->sheet;

            foreach($files as $key => $item)
            {
                if(empty($sheet[$item]))
                    continue;

                $files[$key] = $sheet[$item];
            }
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $files,
                NULL,
                'A1'
            );

        //设置单元格宽度，自动
        $spreadsheet->getActiveSheet()->getDefaultColumnDimension('A')->setWidth(22);

        return $this->downExcel($spreadsheet, $this->getTable() . '.xlsx');
    }

    public function downExcel($spreadsheet, $name)
    {
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $name . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    /**
     * 批量添加成功之后的事件
     * 比如更新缓存操作
     */
    public function afterAllCreateEvent()
    {

    }

    /**
     * 复制
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function copy(Request $request)
    {
        $id = $request->input('id');
        $form = $this->model->find($id);
        $obj = $form->replicate();
        $r = $obj->save();
        if ($r) {
            $this->copyAfter($form,$obj);
            $this->allAfterEvent();
            return $this->returnOkApi('复制成功');
        }
        return $this->returnErrorApi('复制失败');

    }

    /**
     * 拷贝成功之后的操作
     * @param $show
     */
    public function copyAfter($show,$new)
    {

    }

    /**
     * 删除之后的事件
     */
    public function deleteAfter($id_arr){

    }

    /**
     * 所有操作事件之后要做的事情,
     * 一般用于更新缓存，删除缓存等操作，删除，复制，导入数据，批量插入，添加或保存数据,表格内编辑
     */
    public function allAfterEvent(){

    }
    //添加限制条件
    public function addEditShowWhere()
    {
        return $this->model;
    }
    /**
     * 表格编辑
     * @param $id
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function editTable(Request $request)
    {
        $ids = $request->input('ids'); // 修改的表主键id批量分割字符串
        //分割ids
        $id_arr = explode(',', $ids);

        $id_arr = is_array($id_arr) ? $id_arr : [$id_arr];

        if (empty($id_arr)) {

            return $this->returnErrorApi('没有选择数据');
        }
        $field = $request->input('field'); // 修改哪个字段
        $value = $request->input('field_value'); // 修改字段值
        $id = 'id'; // 表主键id值
        $r = $this->addEditShowWhere()->whereIn($id, $id_arr)->update([$field => $value]);

        if ($r) {
            $this->editTableAfterSuccess($field, $id_arr);
            $this->allAfterEvent();

            self::behavior($this->pageName . ' [' . implode(',', $id_arr). '] 修改成功');

            return $this->returnOkApi('修改成功');
        }

        return $this->returnOkApi('失败成功');
    }

    /**
     * 表格编辑后面的操作事件
     * @param $field
     * @param $ids
     */
    public function editTableAfterSuccess($field, $ids)
    {

    }

    /**
     * 检查是否存在错误，直接返回错误字符串
     */
    public function checkDelet($id_arr)
    {

    }

    /**
     * 删除
     * @param $id
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('ids'); // 修改的表主键id批量分割字符串
        $type_id = $request->input('type_id');
        //分割ids
        $id_arr = explode(',', $ids);

        $id_arr = is_array($id_arr) ? $id_arr : [$id_arr];
        if (empty($id_arr)) {

            return $this->returnErrorApi('没有选择数据');
        }
        $error = $this->checkDelet($id_arr);
        if ($error) {
            return $this->returnErrorApi($error);
        }

        $model=$this->delModelAddWhere();
        $r = $model->whereIn($type_id, $id_arr)->delete();
        if ($r) {
            $this->deleteAfter($id_arr);
            $this->allAfterEvent();

            self::behavior($this->pageName. ' [' . implode(',', $id_arr). '] 成功删除');

            return $this->returnOkApi('删除成功');
        }

        return $this->returnErrorApi('删除失败');
    }
    //增加删除条件
    public function delModelAddWhere(){
        return $this->model;
    }
    /**
     * 批量添加附加验证
     * 返回数组['code'=>1,'msg'=>'描述']表示有错误
     */
    public function allCreateExtendValidate(){

    }
}
