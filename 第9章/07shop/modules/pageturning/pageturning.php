<? defined("_ACCESS_") or die('Restricted access'); ?>
<?
/**
 * @version		1.0
 * @package		Hono->萌女郎
 * @.
 * @Website		. 您好
 */
 ?>
<link href="<?=$SETUPFOLDER?>/modules/pageturning/css/style.css" rel="stylesheet" type="text/css">
<div style="text-align:right;"  class="pageturning_container">共
  <?=$totalnum?>
  条, 共
  <?=$page_num?>
  页, 第
  <?=$page?>
  页 <a href="javascript:first()">第一页</a> <a href="javascript:next()">下一页</a> <a  href="javascript:pre()">上一页</a> <a  href="javascript:last()" >最后一页</a>
  <select name="position" id="position"  onchange="goposition()">
    <option value=""></option>
    <?
					     			for($i=1;$i<=$page_num;$i++)
					     			{
						   			echo "<option ";
						   				if(page==$i){echo "selected";}
						   					echo " value=$i>";
						   					echo $i;
						   					echo "</option>" ;
					     			}
					     	?>
  </select>
<input type="hidden" name="page" value=<?=$page?>>
    <input type="hidden" name="totalpage" value=<?=$page_num?>>
    <script language="javascript">
	function first()
	{
		var form=form1;
		if(eval(form.page.value)==1)
			return;
		form.page.value=1;
		form.submit();
	}

	function next()
	{
		var form=form1;
		if(eval(form.page.value)>=eval(form.totalpage.value))
			return;
		form.page.value=eval(form.page.value)+1;
		form.submit();
	}

	function last()
	{
		var form=form1;
		if(eval(form.page.value)==eval(form.totalpage.value))
			return;
		form.page.value=eval(form.totalpage.value);
		form.submit();
	}

	function pre()
	{
		var form=form1;
		if(form.page.value<=1)
			return;
		form.page.value=eval(form.page.value)-1;
		form.submit();
	}

	function  goposition()
	{
		var form=form1;
		form.page.value=form.position.value;
		form.submit();
	}
</script>
</div>


