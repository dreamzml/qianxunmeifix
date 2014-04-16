<?php
/* @var $this GuideController */

?>

<tr>
  <td width="56%" >
    <?php echo CHtml::link(Img::thumb($data->member->mem_logo,50,50,$data->member->mem_name),(Yii::app()->user->id==$data->mem_id)?array('/home/userCenter/index'):'javascript:',array('class'=>'img01')) ?>
    <?php echo CHtml::link(Format::str_cut($data->pos_title,25),array('/home/show/view','id'=>$data->pos_id),array('class'=>'title_01','target'=>'_blank','title'=>$data->pos_title)) ?>
  </td>

  <td width="17%">
    <p>
      <?php echo CHtml::link($data->member->mem_name,(Yii::app()->user->id==$data->mem_id)?array('/home/userCenter/index'):'javascript:') ?>
    </p>
    <p><?php echo Format::dateToDesp($data->inputtime,'Y-m-d H:i') ?></p>
  </td>
  
  <td width="12%">
    <p class="color12"><?php echo $data->info->pos_view_count ?></p>
    <p><?php echo $data->info->pos_comment_count ?></p></td>
  <td width="15%">
    <p class="color13">
      <?php echo ($data->info->priv_comment_user)?'我叫'.$data->info->priv_comment_user->mem_name:'' ?>
    </p>
    <p><?php if($data->info->priv_comment_user) echo Format::dateToDesp($data->info->pos_comment_prevtime) ?></p></td>
</tr>