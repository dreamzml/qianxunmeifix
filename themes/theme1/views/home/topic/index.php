<?php
/* @var $this TopicController */

$etopicType = Options::etopictype();
$orderType = array('1'=>'最新发表','2'=>'最新回复','3'=>'最多回复');

$selectOptions =  CHtml::beginForm('','GET',array('id'=>'filter_form'))
                  .'<span class="pull-left"><em>筛选：</em>'
                  .CHtml::dropDownList('type',$model->cate_id,$etopicType,array('class'=>'span2','empty'=>'全部'))
                  .'</span><span class="pull-left" style="padding-left:10px;"><em>排序：</em>'
                  .CHtml::dropDownList('order',$model->order,$orderType,array('class'=>'span2'))
                  .'</span>'.CHtml::endForm();

Unit::jscript("
    $('.gossip_table_a tr:even').addClass('bg001');
    $('#filter_form select').bind('change',function(){ $(this).parents('form').submit(); });
  ");
?>


<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$model->search(13),
  'itemView'=>'_view',
  'itemsOptions'=>array('class'=>'gossip_list_a'),
  'pagerCssClass'=>'mtop20 text-center',
  'itemsTagName'=>'table',
  'summaryText'=>'{page}/{count}',
  'itemsOptions'=>array('class'=>'gossip_table_a','width'=>'100%','border'=>'0','cellpadding'=>'0','cellspacing'=>'0'),
  'bathHeader'=>true,
  'miniPager'=>true,
  'itemsHeader'=>array(
      $selectOptions,
      '作者',
      '查看/回复',
      '最新回复',
  ),
  'bathButtons'=>array(
      CHtml::link('<span class="b_x">+</span> 创建话题',array('create'),array('class'=>'gossip_btn')) 
  ),
  'pager'=>array(
            'class'=>'CLinkPager',
            'header'=>'',
            'cssFile'=>'/css/home/pager.css',
            'nextPageLabel'=>'下一页',
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'末页',
            'maxButtonCount'=>'10'
          ),
  'onlyPager'=>true,
  'tagName'=>'none',
)); ?>

