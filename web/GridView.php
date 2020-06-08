<?php

namespace melon\web;

use Closure;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\widgets\BaseListView;
use melon\assets\GridViewAsset;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\LinkPager;

class GridView extends BaseListView
{
	public $dataUrl='';
	public $toolbar='<button class="layui-btn layui-btn-sm data-add-btn"> 添加 </button>';
	public $tableLayData=['page'=>'{limit: 5, count: 50}'];
	public $dataColumnClass="melon\web\DataColumn";
	public $tableOptions = ['class' => 'layui-table'];
	public $layout = "{items}\n{pager}";
	
	public $formatter;
	public $columns = [];
	
	/**
	 * @var bool whether to show the header section of the grid table.
	 */
	public $showHeader = true;
	
	/**
	 * @var array the HTML attributes for the table header row.
	 * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
	 */
	public $headerRowOptions = [];
	public $rowOptions = [];
	
	public function init(){
		parent::init();
		$view = $this->getView();
		$view->layuis[]='table';
		$view->layuis[]='laypage';
		if(empty($this->dataUrl)){
			$this->dataUrl=Url::toRoute('data');
		}
		if ($this->formatter === null) {
			$this->formatter = Yii::$app->getFormatter();
		} elseif (is_array($this->formatter)) {
			$this->formatter = Yii::createObject($this->formatter);
		}
		if (!$this->formatter instanceof Formatter) {
			throw new InvalidConfigException('The "formatter" property must be either a Format object or a configuration array.');
		}
		
		$this->initColumns();
	}
	
	public function run()
	{
		$view = $this->getView();
		GridViewAsset::register($view);
		if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
			$content = preg_replace_callback('/{\\w+}/', function ($matches) {
				$content = $this->renderSection($matches[0]);
				
				return $content === false ? $matches[0] : $content;
			}, $this->layout);
		} else {
			$content = $this->renderEmpty();
		}
		
		$js=<<<JS
/*
laypage.render({
	elem: 'test1' //注意，这里的 test1 是 ID，不用加 # 号
	,count: 36 //数据总数，从服务端得到
	,limit: 10
	,layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
	//,curr: 5 //设定初始在第 5 页
	
	,first: false //不显示首页
	,last: false //不显示尾页
	,jump: function(obj, first){
		//obj包含了当前分页的所有参数，比如：
		console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。
		console.log(obj.limit); //得到每页显示的条数
	
		//首次不执行
		if(!first){

			var formData =new FormData($("#w0")[0]);
			//上述方法等价于
			table.reload('w1', {
				method: 'POST',
				where: formData,
				contentType:false
				,page: {
					curr: 1 //重新从第 1 页开始
				}
			}); //只重载数据

		}
	}
});
*/
JS;
		$view = $this->getView();
		$view->registerJs($js);
		echo $content;
	}
	
	/**
	 * Renders the data models for the grid view.
	 * @return string the HTML code of table
	 */
	public function renderItems()
	{
		$id = $this->options['id'];
		$this->tableOptions['id']=$id;
		if(!empty($this->toolbar)){
			$this->tableLayData['toolbar'] = Html::tag('div', $this->toolbar, ['class'=>'layui-btn-container']);
		}
		//$this->tableLayData['page'] = "{count: 36,layout: ['limit', 'count', 'prev', 'page', 'next', 'skip']}";
		//$this->tableLayData['url']='http://localhost:8082/auth/rule/data.html?m=MENU_3';
		$this->tableOptions['lay-data']=Json::encode($this->tableLayData);
		
		$tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
		$tableBody = $this->renderTableBody();
		/*
		$caption = $this->renderCaption();
		$columnGroup = $this->renderColumnGroup();
		
		$tableFooter = false;
		$tableFooterAfterBody = false;
		
		if ($this->showFooter) {
			if ($this->placeFooterAfterBody) {
				$tableFooterAfterBody = $this->renderTableFooter();
			} else {
				$tableFooter = $this->renderTableFooter();
			}
		}
		
		$content = array_filter([
			$caption,
			$columnGroup,
			$tableHeader,
			$tableFooter,
			$tableFooterAfterBody,
		]);
		*/
		$content = array_filter([
			$tableHeader,
			$tableBody,
		]);
		return Html::tag('table', implode("\n", $content), $this->tableOptions);
		
	}
	
	
	
	
	/**
	 * Creates column objects and initializes them.
	 */
	protected function initColumns()
	{
		if (empty($this->columns)) {
			$this->guessColumns();
		}
		foreach ($this->columns as $i => $column) {
			if (is_string($column)) {
				$column = $this->createDataColumn($column);
			} else {
				$column = Yii::createObject(array_merge([
					'class' => $this->dataColumnClass ?: DataColumn::className(),
					'grid' => $this,
				], $column));
			}
			if (!$column->visible) {
				unset($this->columns[$i]);
				continue;
			}
			$this->columns[$i] = $column;
		}
	}
	
	/**
	 * Creates a [[DataColumn]] object based on a string in the format of "attribute:format:label".
	 * @param string $text the column specification string
	 * @return DataColumn the column instance
	 * @throws InvalidConfigException if the column specification is invalid
	 */
	protected function createDataColumn($text)
	{
		if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
			throw new InvalidConfigException('The column must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
		}
		
		return Yii::createObject([
			'class' => $this->dataColumnClass ?: DataColumn::className(),
			'grid' => $this,
			'attribute' => $matches[1],
			'format' => isset($matches[3]) ? $matches[3] : 'text',
			'label' => isset($matches[5]) ? $matches[5] : null,
		]);
	}
	
	/**
	 * Renders the table header.
	 * @return string the rendering result.
	 */
	public function renderTableHeader()
	{
		$cells = [];
		foreach ($this->columns as $column) {
			/* @var $column Column */
			$cells[] = $column->renderHeaderCell();
		}
		$content = Html::tag('tr', implode('', $cells), $this->headerRowOptions);
		
		return "<thead>\n" . $content . "\n</thead>";
	}
	
	/**
	 * Renders the table body.
	 * @return string the rendering result.
	 */
	public function renderTableBody()
	{
		$models = array_values($this->dataProvider->getModels());
		$keys = $this->dataProvider->getKeys();
		$rows = [];
		foreach ($models as $index => $model) {
			$key = $keys[$index];
			$rows[] = $this->renderTableRow($model, $key, $index);
		}
		
		if (empty($rows) && $this->emptyText !== false) {
			$colspan = count($this->columns);
			
			return "<tbody>\n<tr><td colspan=\"$colspan\">" . $this->renderEmpty() . "</td></tr>\n</tbody>";
		}
		
		return "<tbody>\n" . implode("\n", $rows) . "\n</tbody>";
	}
	
	/**
	 * Renders a table row with the given data model and key.
	 * @param mixed $model the data model to be rendered
	 * @param mixed $key the key associated with the data model
	 * @param int $index the zero-based index of the data model among the model array returned by [[dataProvider]].
	 * @return string the rendering result
	 */
	public function renderTableRow($model, $key, $index)
	{
		$cells = [];
		/* @var $column Column */
		foreach ($this->columns as $column) {
			$cells[] = $column->renderDataCell($model, $key, $index);
		}
		if ($this->rowOptions instanceof Closure) {
			$options = call_user_func($this->rowOptions, $model, $key, $index, $this);
		} else {
			$options = $this->rowOptions;
		}
		$options['data-key'] = is_array($key) ? json_encode($key) : (string) $key;
		
		return Html::tag('tr', implode('', $cells), $options);
	}
	
	/**
	 * Renders the pager.
	 * @return string the rendering result
	 */
	public function renderPager()
	{
		$pagination = $this->dataProvider->getPagination();
		if ($pagination === false || $this->dataProvider->getCount() <= 0) {
			return '';
		}
		/* @var $class LinkPager */
		$pager = $this->pager;
		$class = ArrayHelper::remove($pager, 'class', LinkPager::className());
		$pager['pagination'] = $pagination;
		$pager['view'] = $this->getView();
		
		return $class::widget($pager);
	}
	
}