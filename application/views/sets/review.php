    <script type="text/javascript" src="<?=base_url('/js/jquery-ui.js')?>"></script>
	<style type="text/css">
    	#all {
    		margin: 20px auto;
    		width: 1152px;
    	}
        .set_all {
            margin: 5% auto;
        }
    	#title {
    		height: 30px;
    		line-height: 30px;
    	}
        .title {
            height: 30px;
            line-height: 30px;
            margin-bottom: 5px;
            background-color: #F2D9B6;
            border-bottom: 1px #B4B5B5 solid;
            border-right: 1px #B4B5B5 solid;
            border-left: 1px #B4B5B5 solid;
            float: left;
            width: 100%;
        }
        .title label {
            margin-left: 20px;
        }
    	.title_intro{
    		line-height: 40px;
    	}
    	.title_intro div {
    		margin-left: 5px;
    	}
        .title_intro input {
            margin-left: 5px
        }
    	.title_intro label {
    		margin-right: 5px;
    		font-size: 16px;
    	}
        .title_intro label {
            padding-left: 20px;
            margin-right: 5px;
            font-size: 14px;
        }
        .sub_intro {
            line-height: 0;
            padding-left: 20px;
            margin-right: 5px;
            font-size: 14px;
            margin-bottom: 10px;
            /*display: inline-block;*/
        }
    	.result_times{
    		text-align: center;
    	}
    	.cen {
    		padding: 20px 10px 15px 10px;
    		margin: 0 auto;
    	}
    	.qno {
    		width: 45px;
    		vertical-align: middle;
    		font-size: 18px;
    	}
    	.qno_c {
    		width: 50px;
    		vertical-align: middle;
    	}
    	.qno_ans {
    		width: 55px;
    		font-size: 16px;
    		vertical-align: middle;
    	}
    	.qno_ans div {
    		margin-bottom: 5px;
    	}
    	.qno_ans input {
    		margin-right: 5px;
    	}
    	.qno_intro {
    		width: 1000px;
    	}
    	#form1 .list td:not(.handle) {
    		padding-bottom: 5px;
            border: #B4B4B5 solid thin;
    	}
        .list th {
            padding-bottom: 5px;
        }
    	.list {
    		margin-bottom: 15px;
    	}
    	.btn {
    		height: 25px;
    		border: 1px #EED6B4 solid;
    	}
    	.btn:active {
    		border: 1px gray dashed;
    	}
    	.input_field {
    		height: 25px;
    	}
        .hidden {
            display: none;
        }
        .list tr td.que {
            padding: 5px;
        }
        .last .list tr td{
            margin-bottom: 10px;
            height: 25px;
            line-height: 25px;
            padding-left: 10px;
            vertical-align: top;
        }
        .que_title {
            font-size: 15px;
            font-weight: bold;
        }
        .tip {
            padding: 5px;
            border: 1px #B4B4B5 solid;
            color: #1A1A1A !important;
            width: auto !important;
            position: absolute;
            text-align: left !important;
            margin-top: -9px;
            line-height: 15px;
            background-color: #F7F3E5;
            z-index: 2;
            display: none;
        }
        #tip_esort {
            margin-left: 20px;
        }
        #tip_csort {
            margin-left: 35px;
        }
        #tip_usort {
            margin-left: 193px;
        }
        #save_div {
            display: none;
        }
        .allans {
            display: none;
        }
        #intro_open {
            top: 0px;
            bottom: 0px;
            left: 0px;
            right: 0px;
            position: fixed;
            opacity: 0.8;
            z-index: 3;
            background:-moz-radial-gradient(center,ellipse cover,rgba(0,0,0,0.4) 0,rgba(0,0,0,0.9) 100%);
            background: -ms-radial-gradient(center,ellipse cover,rgba(0,0,0,0.4) 0,rgba(0,0,0,0.9) 100%);
            background: -webkit-radial-gradient(center,ellipse cover,rgba(0,0,0,0.4) 0,rgba(0,0,0,0.9) 100%);
            filter:"progid:DXImageTransform.Microsoft.gradient(startColorstr='#66000000',endColorstr='#e6000000',GradientType=1)";
            -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
            display: none;
        }
        #intro_all {
            width: 100%;
            position: fixed;
            z-index: 5;
            top: 0px;
            margin: 7% auto;
            display: none;
        }
        #intro_content {
            width: 500px;
            margin: 0% auto;
            position: relative;
            float: none;
            height: 150px;
            border-radius: 10px;
            height: 80px;
        }
        #intro_title {
            font-size: 20px;
            text-align: center;
            line-height: 80px;
        }
        #quick_no div {
            display: inline-block;
            font-size: 20px;
            border: 1px gray solid;
            line-height: 20px;
            color: white;
            background-color: gray;
            padding: 2px;
            position: relative;
            margin-right: 5px;
        }
        .now {
            background-color: #F8CD89;
            border-color: #FBCD89;
        }
        .bpart_div {
            text-align: center;
            display: inline-block;
        }
        #quick_no {
            margin: 0px 10px 0px 10px;
        }
        textarea {
            width: 500px;
            height: 65px;
            margin: 5px 0px 5px 0px;
            border: 1px #EED6B4 solid;
        }
        .deep {
            background-color: #F5F5F4;
        }
        .shallow {
            background-color: #FCFCFC;
        }
        .shallow td{
            padding: 10px 0px 10px 0px;
        }
        .part_sort {
            display: inline-block;
            visibility: hidden;
            cursor: move;
        }
        .sub_del {
            margin-right: 10px;
            /*float: right;*/
            margin-top: 5px;
            cursor: pointer;
            right: 0;
            position: absolute;
            display: inline-block;
        }
        .sub_update_del {
            margin-right: 10px;
            margin-top: 5px;
            cursor: pointer;
        }
        #part_func {
            display: none;
        }
        .handle {
            vertical-align: middle;
            visibility: hidden;
            cursor: move;
        }
        .show_handle {
            visibility: visible;
        }
        #sets_filed > .set_all {
            width: 90%;
            height: 80%;
        }
	</style>
	<title><?=$title?></title>
</head>
<body>
<div id="all">
	<div id="title"><label class="f17"><?=$title?></label></div>
	<div class="title"><label class="f17"><?=$Set_name?> 摘要</label></div>
    <div class="title_intro">
        <label>總分</label><?=$Sum?>
        <label>及格分數</label><?=$Pass?>
        <label>限時</label><?=$Limtime?>
	</div>
    <div class="title"><label class="f17" style="float:left;" onclick="zoom()">大題</label><img style="float:left;margin-top:5px;" id="part_img" src="<?=base_url('open.png')?>" width="20" height="20"></div>
    <div id="part_div" class="title_intro" style="padding-bottom:10px;">
        <!--<input type="button" name="" id="" onclick="moreone()" class="btn w100 h25" value="增加"> -->
        <?php if (!$Finish): ?>
        <input type="button" onclick="open_part()" class="btn w100 h25" name="" id="start_part" value="開啟排序">
        <span id="part_func"><input type="button" onclick="close_part()" class="btn w100 h25" name="" id="" value="關閉排序">　
        <input type="button" onclick="save_part()" class="btn w100 h25" name="" id="" value="儲存排序">　
        </span>
        <?php endif; ?>
        <div id="part_section"><?=$Part_cont?></div>
        <div><?=$Part_btn?></div>
    </div>
    <?php 
    if ($Sub):
        foreach ($Part as $k => $v):
            $part_hiden = ($k==0) ? '':'hidden';
    ?>
    <div name="part" id="part<?=$v->ID?>" class="allpart <?=$part_hiden?>">
        <div class="title"><label class="f17">題目(第<?=($k+1)?>大題)</label></div>
        <?php if (!$Finish): ?>
        <div class="title_intro">
            <input type="button" class="btn w150" onclick="open_s(<?=$v->ID?>)" name="esort" id="esort<?=$v->ID?>" value="開啟排序">
            <div class="tip" id="tip_esort<?=$v->ID?>">※開啟排序，按住每題題號可以拖曳喔</div>
            <input type="button" class="btn w150 hidden" onclick="close_s(<?=$v->ID?>)" name="csort" id="csort<?=$v->ID?>" value="關閉排序">
            <div class="tip" id="tip_csort<?=$v->ID?>">※關閉排序，但不儲存</div>
            <input type="button" class="btn w150 hidden" onclick="save_s(<?=$v->ID?>)" name="usort" id="usort<?=$v->ID?>" value="儲存排序">
            <div class="tip" id="tip_usort<?=$v->ID?>">※儲存並關閉排序</div>
        </div>
        <?php endif; ?>
    	<div class="content" data-id="<?=$v->ID?>">
    		<div class="cen">
       			<table class="list" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>題號</th>
                            <th>答案</th>
                            <th>題目</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="sort<?=$v->ID?>">
                    <?php foreach ($Sub_que[$k] as $sv):?>
                        <tr align="center" name="node" id="<?=$sv->QID?>">
                            <td class="handle">: :</td>
                            <td class="qno"><?=$sv->SQ_SORT?></td>
                            <td class="qno_ans"><?=$sv->ANS?></td>
                            <td width="1000" align="left" class="que"><?=$sv->QCONT?></td>
                            <td><?php if (!$Finish){ ?><a href="javascript:void(0)" onclick="remq(<?=$v->ID?>,<?=$sv->SQ_SORT?>)" title="移除"><img height="20" src="<?=base_url('/images/icon_op_f.png')?>"><?php } ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
    			</table>
    		</div>
    	</div>
    </div>
    <?php endforeach;
    else:
    ?>
    <div name="part" id="part<?=$SETID?>">
        <div class="title"><label class="f17">題目</label></div>
        <div class="title_intro ">
            <input type="button" class="btn w150" onclick="open_s(<?=$SETID?>)" name="esort" id="esort<?=$SETID?>" value="開啟排序">
            <div class="tip" id="tip_esort<?=$SETID?>">※開啟排序，按住每題題號可以拖曳喔</div>
            <input type="button" class="btn w150 hidden" onclick="close_s(<?=$SETID?>)" name="csort" id="csort<?=$SETID?>" value="關閉排序">
            <div class="tip" id="tip_csort<?=$SETID?>">※關閉排序，但不儲存</div>
            <input type="button" class="btn w150 hidden" onclick="save_s(<?=$SETID?>)" name="usort" id="usort<?=$SETID?>" value="儲存排序">
            <div class="tip" id="tip_usort<?=$SETID?>">※儲存並關閉排序</div>
            <!--  <input type="button" class="btn w100 hidden" name="rsort" id="rsort<?=$v->ID?>" onclick="rand_sort(<?=$v->ID?>)" value="隨機排序">
            <input type="button" class="btn w100 hidden" name="nsort" id="nsort<?=$v->ID?>" onclick="recover_sort(<?=$v->ID?>);" value="回復排序"> -->
        </div>
        <div class="content qus" data-id="<?=$SETID?>">
            <div class="cen">
                <table class="list" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>題號</th>
                            <th>答案</th>
                            <th>題目</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="sort<?=$SETID?>">
                    <?php foreach ($First_que as $v):?>
                        <tr align="center" name="node" id="<?=$v->QID?>">
                            <td class="handle">: :</td>
                            <td class="qno"><?=$v->SQ_SORT?></td>
                            <td class="qno_ans"><?=$v->ANS?></td>
                            <td width="1000" align="left" class="que"><?=$v->QCONT?></td>
                            <td><?php if (!$Finish){ ?><a href="javascript:void(0)" onclick="remq(<?=$SETID?>,<?=$sv->SQ_SORT?>)" title="移除"><img height="20" src="<?=base_url('/images/icon_op_f.png')?>"></a><?php } ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<div id="intro_open"></div>
<div id="intro_all">
    <div id="intro_content" class="set_content">
        <div id="intro_title">更新中...</div>
    </div>
</div>
<!-- <form id="setsjoinq">
    <input type="hidden" name="ques" id="joinque">
    <input type="hidden" name="sets" value="<?=$SETID?>">
    <input type="hidden" name="part" id="part">
</form> -->
<form id="setsort" name="setsort">
    <input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>">
    <input type="hidden" name="node" id="node">
    <input type="hidden" name="s" id="s" value="<?=$SETID?>">
    <input type="hidden" name="t" id="t" value="p">
</form>
<div id="sets_filed" class="list_set">
    <div class="set_all">
        <img src="<?=base_url('/loading.gif')?>" id="loading_status">
        <iframe width="1500" height="100%" id="que_pic"></iframe>
        <input type="button" style="float:right;" name="" id="" value="關閉" class="btn w100" onclick="close_pic()">
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="<?=base_url('/jsfunc/sets_review.js')?>"></script>
<script type="text/javascript">

window.moveTo(0,0);window.resizeTo(screen.width,screen.height);

<?php if (!$Finish): ?>
$('document').ready(function() {
    var sort_ar = [<?=implode(',', $Part_ar)?>];
    sort_ar.forEach(function(i){
        var sort = gb('sort'+i);
        $(sort).sortable({
            handle: '.handle',
            opacity: 0.6,
            //拖曳時透明
            cursor: 'move',
            //游標設定
            axis:'y',
            //只能垂直拖曳
            update : function () { 
            } 
        });
        $(sort).sortable('disable');
    });
    var ps = gb('part_section');
      $(ps).sortable({
        handle: '.part_sort',
        opacity: 0.6,
        //拖曳時透明
        cursor: 'move',
        //游標設定
        axis:'y',
        //只能垂直拖曳
        update : function () { 
        } 
      });
      $(ps).sortable('disable');
});
<?php endif; ?>
function open_part(){
    var sort = gb('part_section');
    $(sort).sortable('enable');
    $(sort).find('.part_sort').css('visibility','visible');
    var start = gb('start_part');
    $(start).hide();
    var func = gb('part_func');
    $(func).show();
}
function close_part(){
    var sort = gb('part_section');
    $(sort).sortable('disable');
    $(sort).find('.part_sort').css('visibility','hidden');
    var start = gb('start_part');
    $(start).show();
    var func = gb('part_func');
    $(func).hide();
}
function save_part(){
    var d=Array();
    var f=0;
    $("div[name=node]").each(function(){
        d[f]=$(this).attr('id');
        f++
    });
    gb('node').value = JSON.stringify(d);
    $('#intro_open').show();
    $('#intro_all').show();
    $.ajax({
        type:"POST",
        url:'<?=site_url('/sets/upd_psort') ?>',
        data: $('#setsort').serialize(),
        dataType:'json',
        success: function(){
            location.reload();
        },
        error: function(rs){
            if (rs.status==400)alert('請重新登入');
        }
    });
}
function remq(p, q){
    $.ajax({
        type:"POST",
        url:"<?=site_url('/sets/delq')?>",
        data:{'p':p,'q':q, csrf_token:getCookie('csrf_token')},
        dataType:"JSON",
        success: function(rs){
            $("#sort"+p).find("#"+q).remove();
        }
    });
}
function open_s(i){
    var sort = gb('sort'+i);
    $(sort).sortable('enable');
    $(sort).find('.handle').addClass('show_handle');
    gb('esort'+i).style.display='none';
    gb('csort'+i).style.display='inline-block';
    gb('usort'+i).style.display='inline-block';
    // gb('nsort'+i).style.display='inline-block';
    // gb('rsort'+i).style.display='inline-block';
}
function close_s(i){
    var sort = gb('sort'+i);
    $(sort).sortable('disable');
    $(sort).find('.handle').removeClass('show_handle');
    gb('esort'+i).style.display='inline-block';
    gb('csort'+i).style.display='none';
    gb('usort'+i).style.display='none';
    // gb('nsort'+i).style.display='none';
    // gb('rsort'+i).style.display='none';
}

function save_s(id){
    $('.sort').sortable('disable');
    var d=Array();
    var f=0;
    $(".list tr[name=node]").each(function(){
        d[f]=$(this).attr('id');
        f++
    });
    var c=JSON.stringify(d);
    $('#intro_open').show();
    $('#intro_all').show();
    $.ajax({
        type:"POST",
        url:"<?=site_url('/sets/upd_qsort')?>",
        data:{node:c,s:id,t:'q', csrf_token:getCookie('csrf_token')},
        dataType:"JSON",
        success:function(rs){
            if (rs.success)location.reload();
        }
    });
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function gb(v){
    return document.getElementById(v);
}
function view(i){
    //every
    // var ipart = document.getElementsByName('intro');
    // $(ipart).hide();
    var bpart = document.getElementsByName('bpart');
    $(bpart).removeClass('now');
    var part = document.getElementsByName('part');
    $(part).hide();
    //now
    // var ipart_now = document.getElementById('intro'+i);
    // $(ipart_now).show();
    var bpart_now = document.getElementById('bpart'+i);
    $(bpart_now).addClass('now');
    var part_now = document.getElementById('part'+i);
    $(part_now).show();
}
function cancel(c){
    var more;
    if (c=='c'){
        more = gb('create');
    }else{
        more = gb('sub_title');
    }
    $(more).hide();
    
}
function zoom(){
    if ($(gb('part_div')).css('display')=='block'){
        gb('part_img').src = '<?=base_url()?>/close.png';
        $(gb('part_div')).hide();
    }else{
        gb('part_img').src = '<?=base_url()?>/open.png';
        $(gb('part_div')).show();
    }
}
$(".ware").on('click', function(){
    gb('part').value = $(this).data("id")
    document.getElementById('que_pic').src="<?=site_url('/question/join')?>";
    $('#sets_filed').show();
    $('#loading_status').show();
    $("#que_pic").load(function(){
        $('#loading_status').hide();
        $('#que_pic').show();
    });
});

function close_pic(){
    $('#sets_filed').hide();
    $('#que_pic').hide();
}
$(".partq").on('click', function(){
    var id = $(this).data("id");
    $(".allpart").hide();
    $("#part"+id).show();
    fetch_qpart(id);
});
function fetch_qpart(v){
    $.ajax({
        type:"GET",
        url:"<?=site_url('sets/ajqpart')?>",
        data:{sid:<?=$SETID?>, part:v},
        dataType:"JSON",
        success:function(rs){
            gb('sort'+v).innerHTML = rs.html;
        }
    });
}
function newque(){
    window.open("<?=site_url('/question/create')?>","_blank","width=800,height=600,resizable=yes,scrollbars=yes,location=no");
}
</script>