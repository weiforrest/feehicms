<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-02 22:55
 */

/**
 * @var $this yii\web\View
 * @var $model frontend\models\Article
 * @var $commentModel frontend\models\Comment
 * @var $prev frontend\models\Article
 * @var $next frontend\models\Article
 * @var $recommends array
 * @var $commentList array
 */


$this->title = $model->title;

?>

<CENTER>
<TABLE width="700" height="100%" align="center" bgcolor="#ffffff">
  <TBODY>
  <TR>
    <TD valign="top">
      <TABLE width="600" align="center" bordercolor="#000000" bgcolor="#ffffff" 
      border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD><!-- title -->             
            <TABLE width="600" align="center" border="0">
              <TBODY>
              <TR>
                <TD height="100"><NOBR>
                  <DIV align="center"><FONT color="#ff0000" 
                  size="+5"><B><?=$model->category->name?></B></FONT>                   </DIV></NOBR>   
                                </TD></TR>
              <TR align="center">
                <TD align="center"><BR><B></B></TD></TR>
              <TR>
                <TD height="36" align="middle">
                  <HR size="4" color="#ff0000">
                </TD></TR>
              <TR>
                <TD height="1" colspan="2"><BR>
                  <P align="center"><FONT face="黑体" 
                  size="5"><?=$model->title?></FONT></P>
                </TD>
              </TR>
              <TR>
                <TD>
                  <P align="center"><FONT face="楷体_GB2312,楷体" 
                  size="3"><?=$model->sub_title?></FONT></P>
                </TD>
              </TR>
                </TBODY></TABLE><!-- end title --> 
                        <!-- ContentStart -->             
            <TABLE width="600" align="center" border="0">
              <TBODY>
              <TR>
                <TD><SPAN style="line-height: 1.7; font-size: 17px;"><BR>
                <FONT face="仿宋_GB2312">
                    <?= $model->articleContent->content ?>
                </FONT> 
                                    </SPAN>                 </TD></TR></TBODY></TABLE><!-- ContentEnd --> 
                      </TD></TR>
        <TR>
          <TD style="padding-left: 2em; font-family: 仿宋_GB2312; font-size: 18px;"></TD></TR>
        <TR>
          <TD></TD></TR>
        <TR>
          <TD>
            <TABLE width="600" align="center" border="0">
              <TBODY>
              <TR>
                <TD colspan="3">
                  <HR width="600" size="3" align="center" style="color: rgb(0, 0, 0);" 
                  noshade="">
                </TD></TR>
              <TR>
                <TD align="left"><NOBR>发布者：<?=$model->author_name?></NOBR></TD>
                <TD align="right"><NOBR><?= Yii::$app->getFormatter()->asDate($model->created_at) ?></NOBR></TD></TR>
              <TR>
                <TD align="right" colspan="2"><NOBR>总共阅读 <?=$model->scan_count?> 次</NOBR></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></CENTER>

