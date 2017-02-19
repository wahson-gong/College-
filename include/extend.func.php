<?php
function litimgurls($imgid=0)
{
    global $lit_imglist,$dsql;
    //��ȡ���ӱ�
    $row = $dsql->GetOne("SELECT c.addtable FROM #@__archives AS a LEFT JOIN #@__channeltype AS c 
                                                            ON a.channel=c.id where a.id='$imgid'");
    $addtable = trim($row['addtable']);
    
    //��ȡͼƬ���ӱ�imgurls�ֶ����ݽ��д���
    $row = $dsql->GetOne("Select imgurls From `$addtable` where aid='$imgid'");
    
    //����inc_channel_unit.php��ChannelUnit��
    $ChannelUnit = new ChannelUnit(2,$imgid);
    
    //����ChannelUnit����GetlitImgLinks������������ͼ
    $lit_imglist = $ChannelUnit->GetlitImgLinks($row['imgurls']);
    
    //���ؽ��
    return $lit_imglist;
}


/*֯֯�������ң�www.wwwcms.net���ַ����˺���*/
function wwwcms_filter($str,$stype="inject") {
	if ($stype=="inject")  {
		$str = str_replace(
		       array( "select", "insert", "update", "delete", "alter", "cas", "union", "into", "load_file", "outfile", "create", "join", "where", "like", "drop", "modify", "rename", "'", "/*", "*", "../", "./"),
			   array("","","","","","","","","","","","","","","","","","","","","",""),
			   $str);
	} else if ($stype=="xss") {
		$farr = array("/\s+/" ,
		              "/<(\/?)(script|META|STYLE|HTML|HEAD|BODY|STYLE |i?frame|b|strong|style|html|img|P|o:p|iframe|u|em|strike|BR|div|a|TABLE|TBODY|object|tr|td|st1:chsdate|FONT|span|MARQUEE|body|title|\r\n|link|meta|\?|\%)([^>]*?)>/isU", 
					  "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
					  );
		$tarr = array(" ",
		              "",
					  "\\1\\2",
					  ); 
		$str = preg_replace($farr, $tarr, $str);
		$str = str_replace(
		       array( "<", ">", "'", "\"", ";", "/*", "*", "../", "./"),
			   array("&lt;","&gt;","","","","","","",""),
			   $str);
	}
	return $str;
}

/**
 *  �����Զ����(���ڷ���)
 *
 * @access    public
 * @param     string  $fieldset  �ֶ��б�
 * @param     string  $loadtype  ��������
 * @return    string
 */
 
function AddFilter($channelid, $type=1, $fieldsnamef, $defaulttid, $loadtype='autofield')
{
	global $tid,$dsql,$id;
	$tid = $defaulttid ? $defaulttid : $tid;
	if ($id!="")
	{
		$tidsq = $dsql->GetOne(" Select typeid From `#@__archives` where id='$id' ");
		$tid = $tidsq["typeid"];
	}
	$nofilter = (isset($_REQUEST['TotalResult']) ? "&TotalResult=".$_REQUEST['TotalResult'] : '').(isset($_REQUEST['PageNo']) ? "&PageNo=".$_REQUEST['PageNo'] : '');
	$filterarr = wwwcms_filter(stripos($_SERVER['REQUEST_URI'], "list.php?tid=") ? str_replace($nofilter, '', $_SERVER['REQUEST_URI']) : $GLOBALS['cfg_cmsurl']."/plus/list.php?tid=".$tid);
    $cInfos = $dsql->GetOne(" Select * From  `#@__channeltype` where id='$channelid' ");
	$fieldset=$cInfos['fieldset'];
	$dtp = new DedeTagParse();
    $dtp->SetNameSpace('field','<','>');
    $dtp->LoadSource($fieldset);
    $dede_addonfields = '';
    if(is_array($dtp->CTags))
    {
        foreach($dtp->CTags as $tida=>$ctag)
        {
            $fieldsname = $fieldsnamef ? explode(",", $fieldsnamef) : explode(",", $ctag->GetName());
			if(($loadtype!='autofield' || ($loadtype=='autofield' && $ctag->GetAtt('autofield')==1)) && in_array($ctag->GetName(), $fieldsname) )
            {
                $href1 = explode($ctag->GetName().'=', $filterarr);
				$href2 = explode('&', $href1[1]);
				$fields_value = $href2[0];
				$dede_addonfields .= '<b>'.$ctag->GetAtt('itemname').'��</b>';
				switch ($type) {
					case 1:
						$dede_addonfields .= (preg_match("/&".$ctag->GetName()."=/is",$filterarr,$regm) ? '<a title="ȫ��" href="'.str_replace("&".$ctag->GetName()."=".$fields_value,"",$filterarr).'">ȫ��</a>' : '<span>ȫ��</span>').'&nbsp;';
					
						$addonfields_items = explode(",",$ctag->GetAtt('default'));
						for ($i=0; $i<count($addonfields_items); $i++)
						{
							$href = stripos($filterarr,$ctag->GetName().'=') ? str_replace("=".$fields_value,"=".urlencode($addonfields_items[$i]),$filterarr) : $filterarr.'&'.$ctag->GetName().'='.urlencode($addonfields_items[$i]);//echo $href;
							$dede_addonfields .= ($fields_value!=urlencode($addonfields_items[$i]) ? '<a title="'.$addonfields_items[$i].'" href="'.$href.'">'.$addonfields_items[$i].'</a>' : '<span>'.$addonfields_items[$i].'</span>')."&nbsp;";
						}
						$dede_addonfields .= '<br/>';
					break;
					
					case 2:
						$dede_addonfields .= '<select name="filter"'.$ctag->GetName().' onchange="window.location=this.options[this.selectedIndex].value">
							'.'<option value="'.str_replace("&".$ctag->GetName()."=".$fields_value,"",$filterarr).'">ȫ��</option>';
						$addonfields_items = explode(",",$ctag->GetAtt('default'));
						for ($i=0; $i<count($addonfields_items); $i++)
						{
							$href = stripos($filterarr,$ctag->GetName().'=') ? str_replace("=".$fields_value,"=".urlencode($addonfields_items[$i]),$filterarr) : $filterarr.'&'.$ctag->GetName().'='.urlencode($addonfields_items[$i]);
							$dede_addonfields .= '<option value="'.$href.'"'.($fields_value==urlencode($addonfields_items[$i]) ? ' selected="selected"' : '').'>'.$addonfields_items[$i].'</option>
							';
						}
						$dede_addonfields .= '</select><br/>
						';
					break;
				}
            }
        }
    }
	echo $dede_addonfields;
}


function Search_addfields($id,$result){    
global $dsql;    
$mnkj = $dsql->GetOne("SELECT * FROM `dede_addonshop` where aid='$id'");    
 $name=$mnkj[$result];    
 return $name;    
 }