<?php
$z[0]=Array("global","",236,264);
$z[0][4]['name']="cfg_soft_lang";
$z[1]=Array("global","",286,312);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("field","",353,375);
$z[2][4]['name']="keywords";
$z[3]=Array("field","",415,466);
$z[3][4]['name']="description";
$z[3][4]['function']="html2text(@me)";
$z[4]=Array("global","",534,562);
$z[4][4]['name']="cfg_mobileurl";
$z[5]=Array("field","",576,592);
$z[5][4]['name']="id";
$z[6]=Array("global","",1061,1089);
$z[6][4]['name']="cfg_mobileurl";
$z[7]=Array("field","",1103,1119);
$z[7][4]['name']="id";
$z[8]=Array("global","",1258,1283);
$z[8][4]['name']="cfg_cmsurl";
$z[9]=Array("global","",1545,1570);
$z[9][4]['name']="cfg_cmsurl";
$z[10]=Array("global","",2548,2573);
$z[10][4]['name']="cfg_phpurl";
$z[11]=Array("global","",2687,2719);
$z[11][4]['name']="cfg_templets_skin";
$z[12]=Array("global","",2786,2818);
$z[12][4]['name']="cfg_templets_skin";
$z[13]=Array("global","",2934,2966);
$z[13][4]['name']="cfg_templets_skin";
$z[14]=Array("include","",3091,3126);
$z[14][4]['filename']="head.htm";
$z[15]=Array("field","",3261,3290);
$z[15][4]['name']="position";
$z[16]=Array("field","",3291,3339);
$z[16][4]['name']="title";
$z[16][4]['function']="cn_substr(@me,2)";
$z[17]=Array("php","\r\n      \r\n      \$GLOBALS['name']=\$arc->Fields['ysxx'];\r\n      \r\n       \$GLOBALS['title']=\$arc->Fields['title'];\r\n       \r\n        \$GLOBALS['sex']=\$arc->Fields['sex'];\r\n        \r\n         \$GLOBALS['pic']=\$arc->Fields['litpic'];\r\n      \r\n      ",3432,3695);
$z[18]=Array("tagname","\r\n    \$str1=\$GLOBALS['name'];\r\n    \$sex=\$GLOBALS['sex'];\r\n    \$pic=\$GLOBALS['pic'];\r\n    @me=\$str1;\r\n        if(\$str1==\"不显示真实姓名真实照片\")\r\n        {	\r\n        	if(\$sex==\"男\")\r\n            {\r\n            	\r\n                @me=\"<img src='/templets/default/images/avatar_teacher_1_male_200.jpg'  width='125' height='155'/>\";\r\n            }\r\n            if(\$sex==\"女\")\r\n            {\r\n            	\r\n                @me=\"<img src='/templets/default/images/avatar_teacher_1_female_200.jpg'  width='125' height='155'/>\";\r\n            }\r\n            \r\n        }\r\n    \r\n        if(\$str1==\"显示真实姓名真实照片\")\r\n        {\r\n             @me=\"<img src='\$pic'  width='125' height='155'/>\";\r\n        }   \r\n",3706,4451);
$z[18][4]['runphp']="yes";
$z[19]=Array("field","",4579,4596);
$z[19][4]['name']="aid";
$z[20]=Array("tagname","\r\n    \$str1=\$GLOBALS['name'];\r\n    \$tit=\$GLOBALS['title'];\r\n    @me=\$str1;\r\n        if(\$str1==\"不显示真实姓名真实照片\")\r\n        {\r\n             @me=cn_substr(\$tit,2).\"老师\";\r\n        }\r\n    \r\n        if(\$str1==\"显示真实姓名真实照片\")\r\n        {\r\n             @me=\$GLOBALS['title'];\r\n        }   \r\n",4677,5017);
$z[20][4]['runphp']="yes";
$z[21]=Array("field","",5100,5125);
$z[21][4]['name']="sknj";
$z[22]=Array("field","",5125,5148);
$z[22][4]['name']="lx";
$z[23]=Array("field","",5180,5205);
$z[23][4]['name']="jage";
$z[24]=Array("field","",5241,5266);
$z[24][4]['name']="area";
$z[25]=Array("field","",5300,5325);
$z[25][4]['name']="jxfs";
$z[26]=Array("field","",5357,5382);
$z[26][4]['name']="skfs";
$z[27]=Array("global","",5613,5645);
$z[27][4]['name']="cfg_templets_skin";
$z[28]=Array("global","",5712,5744);
$z[28][4]['name']="cfg_templets_skin";
$z[29]=Array("global","",5811,5843);
$z[29][4]['name']="cfg_templets_skin";
$z[30]=Array("global","",5910,5942);
$z[30][4]['name']="cfg_templets_skin";
$z[31]=Array("global","",6009,6041);
$z[31][4]['name']="cfg_templets_skin";
$z[32]=Array("field","",6221,6244);
$z[32][4]['name']="id";
$z[33]=Array("field","",6867,6893);
$z[33][4]['name']="xueli";
$z[34]=Array("field","",6976,6999);
$z[34][4]['name']="zy";
$z[35]=Array("field","",7076,7101);
$z[35][4]['name']="byyx";
$z[36]=Array("field","",7267,7292);
$z[36][4]['name']="area";
$z[37]=Array("field","",7468,7493);
$z[37][4]['name']="xslx";
$z[38]=Array("field","",7616,7641);
$z[38][4]['name']="jxtd";
$z[39]=Array("field","",7982,8007);
$z[39][4]['name']="body";
$z[40]=Array("field","",8285,8310);
$z[40][4]['name']="gwjl";
$z[41]=Array("field","",8594,8619);
$z[41][4]['name']="jxal";
$z[42]=Array("include","",8912,8953);
$z[42][4]['file']="ajaxfeedback2.htm";
$z[43]=Array("field","",9176,9202);
$z[43][4]['name']="price";
$z[44]=Array("php","\$GLOBALS['xxoo']=\$arc->Fields['sjd'];",9544,9602);
$z[45]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周一上午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                        @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"上\";\r\n                                    }\r\n                                    ",9925,10523);
$z[45][4]['runphp']="yes";
$z[46]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周二上午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"上\";\r\n                                    }\r\n                                    ",10609,11206);
$z[46][4]['runphp']="yes";
$z[47]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周三上午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"上\";\r\n                                    }\r\n                                    ",11263,11860);
$z[47][4]['runphp']="yes";
$z[48]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周四上午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"上\";\r\n                                    }\r\n                                    ",11879,12476);
$z[48][4]['runphp']="yes";
$z[49]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周五上午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"上\";\r\n                                    }\r\n                                    ",12495,13092);
$z[49][4]['runphp']="yes";
$z[50]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周六上午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"上\";\r\n                                    }\r\n                                    ",13111,13708);
$z[50][4]['runphp']="yes";
$z[51]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周日上午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"上\";\r\n                                    }\r\n                                    ",13727,14324);
$z[51][4]['runphp']="yes";
$z[52]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周一中午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                        @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                        @me=\"下\";\r\n                                    }\r\n                                    ",14411,15010);
$z[52][4]['runphp']="yes";
$z[53]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周二中午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"下\";\r\n                                    }\r\n                                    ",15096,15693);
$z[53][4]['runphp']="yes";
$z[54]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周三中午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"下\";\r\n                                    }\r\n                                    ",15750,16347);
$z[54][4]['runphp']="yes";
$z[55]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周四中午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"下\";\r\n                                    }\r\n                                    ",16366,16963);
$z[55][4]['runphp']="yes";
$z[56]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周五中午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"下\";\r\n                                    }\r\n                                    ",16982,17579);
$z[56][4]['runphp']="yes";
$z[57]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周六中午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"下\";\r\n                                    }\r\n                                    ",17598,18195);
$z[57][4]['runphp']="yes";
$z[58]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周日中午';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"下\";\r\n                                    }\r\n                                    ",18214,18811);
$z[58][4]['runphp']="yes";
$z[59]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周一晚上';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                        @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"晚\";\r\n                                    }\r\n                                    ",18898,19496);
$z[59][4]['runphp']="yes";
$z[60]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周二晚上';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"晚\";\r\n                                    }\r\n                                    ",19582,20179);
$z[60][4]['runphp']="yes";
$z[61]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周三晚上';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"晚\";\r\n                                    }\r\n                                    ",20236,20833);
$z[61][4]['runphp']="yes";
$z[62]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周四晚上';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"晚\";\r\n                                    }\r\n                                    ",20852,21449);
$z[62][4]['runphp']="yes";
$z[63]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周五晚上';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"晚\";\r\n                                    }\r\n                                    ",21468,22065);
$z[63][4]['runphp']="yes";
$z[64]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周六晚上';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"晚\";\r\n                                    }\r\n                                    ",22084,22681);
$z[64][4]['runphp']="yes";
$z[65]=Array("tagname","\r\n                                    \$str=\$GLOBALS['xxoo'];\r\n                                    \$needle ='周日晚上';//判断是否包含a这个字符\r\n                                    \$tmparray = explode(\$needle,\$str);\r\n                                    if(count(\$tmparray)>1){\r\n                                       @me=\"<img src='/templets/default/images/selected_time.png' alt=''>\";\r\n                                    } else{\r\n                                       @me=\"晚\";\r\n                                    }\r\n                                    ",22700,23297);
$z[65][4]['runphp']="yes";
$z[66]=Array("arclist","\r\n         <li>\r\n         [field:textlink/]\r\n         <span>[field:pubdate function=\"MyDate('m-d',@me)\"/]</span>\r\n\r\n        </li>\r\n",23466,23660);
$z[66][4]['typeid']="8";
$z[66][4]['row']="10";
$z[66][4]['titlelen']="20";
$z[67]=Array("field","",23835,23862);
$z[67][4]['name']="phpurl";
$z[68]=Array("field","",23886,23909);
$z[68][4]['name']="id";
$z[69]=Array("field","",23914,23938);
$z[69][4]['name']="mid";
$z[70]=Array("include","",24008,24045);
$z[70][4]['filename']="footer.htm";

?>