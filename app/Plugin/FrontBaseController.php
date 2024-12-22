<?php

namespace App\Plugin;



class FrontBaseController extends PluginController
{

    public function returnError($code, $message,$url)
    {

        return view('plugin.layout.error')->with(['code' => $code, 'msg' => $message,'url'=>$url]);
    }

}
