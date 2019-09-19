<?php
/*
 * 控制器 基类
 *
 */

use Phalcon\Mvc\Controller as PhalconController;

class ControllerInit extends PhalconController
{
    # 控制器调用顺序:
    # beforeExecuteRoute($dispatcher)
    # initialize()
    # onConstruct()
    # afterExecuteRoute($dispatcher)

    public function initialize()
    {
        if($this->modelClass){
            $this->model = ($this->modelClass)::instance();
        }
        # 请求路由
        $controller = strtolower($this->dispatcher->getControllerName());
        $action = strtolower($this->dispatcher->getActionName());
        $uri = 'index' != $action ? '/'.$action : '';
        $uri = 'index' != $controller ? $controller.$uri : '';
        $this->requestURI = '/'.$uri;
    }

    protected $model;
    protected $modelClass;
    protected $requestURI;

    /**
     * 通用筛选查询构造器
     *
     * @param $modelClass
     * @param $alias
     * @return \Phalcon\Mvc\Model\Query\BuilderInterface
     */
    protected function filterQuery($modelClass = null, $alias = null)
    {
        $modelClass = $modelClass ?? $this->modelClass;
        $query = $this->modelsManager->createBuilder();
        $alias ? $query->from([$alias => $modelClass]) : $query->from($modelClass);
        $filter = $this->get('filter',null,[]);
        $order = $this->get('order',null,[]);
        $symbols = [
            'eq'    => ' = ',
            'neq'   => ' <> ',
            'gt'    => ' > ',
            'egt'   => ' >= ',
            'lt'    => ' < ',
            'elt'   => ' <= ',
            'like'  => ' LIKE ',
            'nlike' => ' NOT LIKE ',
            'in'    => ' IN ',
            'nin'   => ' NOT IN ',
            'btn'   => ' BETWEEN ',
            'nbtn'  => ' NOT BETWEEN ',
        ];
        $columns = $modelClass::columns();
        foreach($filter as $i => $item){
            if(! isset($columns[$item['field']]) || ! isset($symbols[$item['symbol']])) continue;
            if(in_array($item['symbol'],['like', 'nlike',])){
                $value = " '%".addslashes($item['value'])."'% ";
            }
            elseif(in_array($item['symbol'],['in', 'nin',])){
                $temp = is_array($item['value']) ? $item['value'] : explode(';',$item['value']);
                $value = '(';
                foreach($temp as $val){
                    $value .= "'".addslashes($val)."',";
                }
                $value = rtrim($value,',').')';
            }
            elseif(in_array($item['symbol'],['btn', 'nbtn',])){
                $temp = is_array($item['value']) ? $item['value'] : explode('~',$item['value']);
                $value = "'".addslashes($temp[0])."' AND '".addslashes($temp[1])."'";
            }
            else{
                $value = "'".addslashes($item['value'])."'";
            }
            $f = $alias ? $alias.'.'.$item['field'] : $item['field'];
            $query->andWhere("{$f} {$symbols[$item['symbol']]} {$value} ");
        }
        $orders = [
            1 => 'ASC',
            2 => 'DESC',
        ];
        $orderBy = [];
        foreach($order as $field => $by){
            if(! isset($orders[$by])) continue;
            $field = $alias ? $alias.'.'.$field : $field;
            $orderBy[] = $field.' '.$orders[$by];
        }
        if(! empty($orderBy)){
            $query->orderBy(implode(',',$orderBy));
        }

        return $query;
    }

    /**
     * 响应查询列表
     *
     * @param \Phalcon\Mvc\Model\Query\BuilderInterface $query
     */
    protected function respQueryList(\Phalcon\Mvc\Model\Query\BuilderInterface $query)
    {
        $isPage = $this->get('isPage','int',1); # 是否分页，0否，1是
        $page = $this->get('page','int',1);
        $perPage = $this->get('perPage','int',20);
        # 分页
        if($isPage){
            $builder = new Phalcon\Paginator\Adapter\QueryBuilder([
                'builder' => $query,
                'limit' => $perPage,
                'page' => $page,
            ]);
            $paginator = $builder->getPaginate();
            Output::json([
                'list' => $paginator->items,
                'isPage' => $isPage,
                'total' => $paginator->total_items,
                'perPage' => $perPage,
                'page' => $page,
            ],'');
        }
        # 不分页
        else{
            $list = $query->getQuery()->execute();
            Output::json([
                'list' => $list,
                'isPage' => $isPage,
            ],'');
        }
    }

    /**
     *  列表
     */
    protected function index()
    {
        $this->respQueryList($this->filterQuery());
    }

    /**
     * 信息
     */
    protected function info()
    {
        $id = $this->request->get('id','int',0);
        if($id < 1){
            Output::json([],'请选择其中一项',412);
        }
        $row = $this->model->findFirst($id);
        if( ! $row){
            Output::json([],'选择的数据不存在',410);
        }

        Output::json($row,'');
    }

    /**
     * 保存
     */
    protected function store($id = null, $input = null)
    {
        $id = is_null($id) ? $this->request->get('id','int',0) : $id;
        $input = is_null($input) ? $this->get('input',null,[]) : $input;
        # 修改
        if($id > 0){
            $row = $this->model->findFirst($id);
            if( ! $row){
                goto add;
            }
            $res = $row->handleSave($input, 'edit');
            $isNew = 0;
        }
        # 添加
        else{
            add:
            $res = $this->model->handleSave($input, 'add');
            $row = $this->model;
            $isNew = 1;
        }
        if(true === $res){
            Output::json([
                'row' => $row,
                'isNew' => $isNew,
            ]);
        }elseif(false === $res){
            Output::json(['id' => $id],'保存失败',507);
        }else{
            Output::json(['id' => $id],$res[0]->getMessage(),406);
        }
    }

    /**
     * 通过ID删除
     */
    protected function del()
    {
        $ids = $this->get('ids');
        if(empty($ids)){
            Output::json([],'请至少选择一项',412);
        }
        if(is_array($ids)){
            $ids = implode(',',$ids);
        }
        $res = $this->model->find('id in ('.$ids.')')->delete();
        if($res){
            Output::json();
        }else{
            Output::json([],'操作失败',423);
        }
    }

    /**
     * 获取请求数据
     *
     * @param $key
     * @param null $filter
     * @param null $default
     * @return mixed|null
     */
    protected function get($key, $filter = null, $default = null)
    {
        $val = $this->request->get($key,$filter);
        if(! is_null($val)) return $val;
        return $this->getInput($key,$default);
    }

    /**
     * 获取 INPUT_RAW 数据
     *
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    protected function getInput($key,$default = null)
    {
        $post = file_get_contents('php://input');
        if(empty($post)) return $default;
        $json = json_decode($post,true);
        if(false !== $json && isset($json[$key])) return $json[$key];
        parse_str(urldecode($post),$query);
        return false !== $query && isset($query[$key]) ? $query[$key] : $default;
    }
}