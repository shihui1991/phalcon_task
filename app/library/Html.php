<?php
/*
 * html 组件生成类
 * */

class Html
{
    /**
     * 生成普通表单输入框
     *
     * @param $model
     * @param $field
     * @param string $type
     * @param array $params
     * @return string
     */
    public static function formInput($model, $field, $type = 'text', $params = [])
    {
        # 获取名称
        $label = $model->getFieldsLabel($field);
        # 获取值
        $get = 'get'.\Phalcon\Text::camelize($field);
        $value = $model->$get();
        # 基本参数
        $args = [
            'type'  => $type,
            'id'    => 'field-'.$field,
            'name'  => $field,
            'value' => htmlspecialchars($value),
            'class' => 'col-xs-10 col-sm-5',
        ];
        $args = array_merge($args,$params);
        $input = '<input ';
        foreach($args as $attr => $val){
            $input .= ' '.$attr.'="'.$val.'" ';
        }
        $input .= '>';

        $html = <<<html
<div class="form-group">
    <label for="field-{$field}" class="col-sm-3 control-label no-padding-right">{$label}</label>
    <div class="col-sm-9">
        {$input}
    </div>
</div>
html;

        return $html;
    }


    /**
     * 生成普通表单单选项
     *
     * @param $model
     * @param $field
     * @return string
     */
    public static function formRadio($model, $field)
    {
        # 获取名称
        $label = $model->getFieldsLabel($field);
        # 获取取值选项
        $range = $model->getFieldsValueDesc($field);
        # 获取值
        $get = 'get'.\Phalcon\Text::camelize($field);
        $value = $model->$get();
        $radio = '';
        $i = 0;
        foreach($range as $val => $title){
            $checked = '';

            if((is_null($value) && 0 == $i) || (!is_null($value) && $value == $val)){
                $checked = 'checked';
            }
            $radio .= <<<radio
<label>
	<input name="{$field}" value="{$val}" type="radio" class="ace" {$checked}/>
	<span class="lbl"> {$title} </span>
</label>
radio;
            $i++;
        }

        $html = <<<html
<div class="form-group">
    <label for="field-{$field}" class="col-sm-3 control-label no-padding-right">{$label}</label>
    <div class="col-sm-9 radio">
        {$radio}
    </div>
</div>
html;

        return $html;
    }

    /**
     * 生成普通表单提交按钮
     *
     * @return string
     */
    public static function formSubmitBtn()
    {
        return <<<html
<div class="clearfix form-actions">
    <div class="col-md-offset-3 col-md-9">
        <button class="btn btn-info" type="submit">
            <i class="ace-icon fa fa-check bigger-110"></i>
            保存
        </button>
    </div>
</div>
html;
    }

    /**
     * 生成普通表单日期输入框
     *
     * @param $model
     * @param $field
     * @param string $type
     * @param array $params
     * @return string
     */
    public static function formDate($model, $field, $type = 'date', $params = [])
    {
        # 获取名称
        $label = $model->getFieldsLabel($field);
        # 获取值
        $get = 'get'.\Phalcon\Text::camelize($field);
        $value = $model->$get();
        # 基本参数
        $args = [
            'type'  => 'text',
            'id'    => 'field-'.$field,
            'name'  => $field,
            'value' => htmlspecialchars($value),
            'class' => 'col-xs-10 col-sm-5 date-picker',
            'data-date-format' => 'yyyy-mm-dd'
        ];
        $args = array_merge($args,$params);
        $input = '<input ';
        foreach($args as $attr => $val){
            $input .= ' '.$attr.'="'.$val.'" ';
        }
        $input .= '>';

        $html = <<<html
<div class="form-group">
    <label for="field-{$field}" class="col-sm-3 control-label no-padding-right">{$label}</label>
    <div class="col-sm-9">
        {$input}
    </div>
</div>
html;

        return $html;
    }

    /**
     * 生成普通表单文本域
     *
     * @param $model
     * @param $field
     * @param array $params
     * @return string
     */
    public static function formTextarea($model, $field, $params = [])
    {
        # 获取名称
        $label = $model->getFieldsLabel($field);
        # 获取值
        $get = 'get'.\Phalcon\Text::camelize($field);
        $value = $model->$get();
        # 基本参数
        $args = [
            'id'    => 'field-'.$field,
            'name'  => $field,
            'class' => 'col-xs-10 col-sm-5',
        ];
        $args = array_merge($args,$params);
        $textarea = '<textarea ';
        foreach($args as $attr => $val){
            $textarea .= ' '.$attr.'="'.$val.'" ';
        }
        $textarea .= '>' . htmlspecialchars($value) . '</textarea>';

        $html = <<<html
<div class="form-group">
    <label for="field-{$field}" class="col-sm-3 control-label no-padding-right">{$label}</label>
    <div class="col-sm-9">
        {$textarea}
    </div>
</div>
html;

        return $html;
    }

    /** 生成树形结构
     * @param array $list       原始数据
     * @param string $str       树形结构样式 如："<option value='\$id' \$selected>\$space \$name</option>"
     * @param int $parentId     一级项目ID
     * @param int $level        初始层级
     * @param array $icon       树形图标
     * @param string $nbsp      图标空格
     * @return string           树形结构字符串
     */
    public static function makeTree($list=array(), $str="<option value='\$id' \$selected>\$space \$name</option>", $parentId=0, $level=1, $treeIcons=array('&nbsp;┃','&nbsp;┣','&nbsp;┗'), $treeNbsp='&nbsp;'){
        $dom = '';
        if(empty($list)){
            return $dom;
        }
        $group = Arr::getChildGroup($list,$parentId);
        $childs = $group['child'];
        $last = $group['last'];
        $num = count($childs);
        if(empty($childs)){
            return $dom;
        }
        $i = 1;
        foreach (Arr::makeArrayIterator($childs) as $child){
            $space='';
            for($j = 1; $j < $level ; $j++){
                if(1 == $j){
                    $space .= $treeNbsp;
                }else{
                    $space .= $treeIcons[0].$treeNbsp;
                }
            }
            if(1 != $level){
                if($i == $num){
                    $space .= $treeIcons[2];
                }else{
                    $space .= $treeIcons[1];
                }
            }
            @extract($child);
            eval("\$nstr = \"$str\";");
            $dom .= $nstr;
            $dom .= static::makeTree($last,$str,$child['id'],$level+1,$treeIcons,$treeNbsp);
            $i++;
        }
        return $dom;
    }

    /**
     * 树形表格
     *
     * @param $list
     * @param $tpl
     * @param int $parentId
     * @param int $level
     * @return string
     */
    public static function makeTreeTable($list, $tpl, $parentId = 0, $level=1)
    {
        return static::makeTree($list,$tpl,$parentId,$level,['','',''],'');
    }

    /**
     * 导航菜单
     *
     * @param $list
     * @param int $parent_id
     * @param int $level
     * @param int $current_id
     * @param array $parents_ids
     * @return string
     */
    public static function makeNav($list, $parent_id = 0, $level = 1, $current_id = 0, $parents_ids = [])
    {
        $str = '';
        $group = Arr::getChildGroup($list,$parent_id);
        $childs = $group['child'];
        $last = $group['last'];

        if(count($childs)){
            foreach($childs as $child){
                if($level==1){
                    $name='<span class="menu-text">'.$child['name'].'</span>';
                }else{
                    $name=$child['name'];
                }
                /* 第二级菜单图标改为箭头 */
                if($level==2){
                    $icon='<i class="menu-icon fa fa-caret-right"></i>';
                }else{
                    $icon=$child['icon'];
                }
                /* li标签class */
                if(in_array($child['id'],$parents_ids)){
                    $li_class=' class="active open" ';
                }elseif($child['id'] == $current_id){
                    $li_class=' class="active" ';
                }else{
                    $li_class='';
                }
                $str_childs = static::makeNav($last,$child['id'],$level+1,$current_id,$parents_ids);
                if($str_childs){
                    $a_class=' class="dropdown-toggle" ';
                    $b_in_a='<b class="arrow fa fa-angle-down"></b>';
                    $str .= '<li '.$li_class.'><a href="'.$child['uri'].'" '.$a_class.'>'.$icon.$name.$b_in_a.'</a><b class="arrow"></b>';
                    $str .= $str_childs;
                }else{
                    $a_class='';
                    $b_in_a='';
                    $str .= '<li '.$li_class.'><a href="'.$child['uri'].'" '.$a_class.'>'.$icon.$name.$b_in_a.'</a><b class="arrow"></b>';
                }
                $str.='</li>';
            }
            /* ul标签class */
            $ul_class=$level==1?'nav nav-list':'submenu';
            $str ='<ul class="'.$ul_class.'">'.$str.'</ul>';
        }

        return $str;
    }

}