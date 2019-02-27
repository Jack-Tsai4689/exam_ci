    <script type="text/javascript" src="<?=base_url('js/jquery.timer.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('js/jquery.form.js')?>"></script>
    <style type="text/css">
        body {
			background-color: white;
		}
    	#all {
    		margin: 20px auto;
    		width: 90%;
    	}
    	.cen {
    		margin: 0 auto;
    		padding: 20px 0px 10px 0px;
    		margin: 0px 20px 0px 20px;
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
    	.input_field {
    		margin:0px;
            width: 500px;
    	}
    	.btn {
    		font-size: 14px;
    	}
    	.f14{
    		margin-left: 5px;
    		margin-right: 5px;
    	}
    	.deep {
    		background-color: #F5F5F4;
    	}
        .deep input {
            margin-left: 5px;
        }
    	.list tr td{
    		margin-bottom: 10px;
    		height: 25px;
    		line-height: 25px;
    		padding-left: 10px;
    		vertical-align: top;
            text-align: center;
    	}
    	.list {
    		/*margin-bottom: 20px;*/
    	}
	</style>
	<title><?=$title?></title>
</head>
<body>
<div id="all">
	<div class="title"><label class="f17"><?=$title?></label></div>
	<div class="content">
		<div class="cen">
            <FORM name="form1" id="form1" method="post" action="<?=site_url('/question/upload_act')?>" enctype="multipart/form-data">
                <br>
                <INPUT type="hidden" name="type" value="<?=$type?>"/>
                <input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>">
                <table class="list" border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr class="deep">
                        <td>上傳<input type="file" name="qmg" id="qmg" size="30" accept="image/jpg,image/png,image/jpeg" /></td>
                    </tr>
                    <tr class="shallow">
                        <td>
                        	<font color="red" id="msg"></font>
                        	<span class="bar"></span><span class="percent"></span><br>
                            <FONT color="#ff0000">上傳的檔案請勿超過<?=$max_file?>MB
                            <br>欲上傳之檔案格式需符合(JPG/PNG/PDF)
                            <br>PDF耗時較久,請耐心等待
                            <br>請使用10頁以內pdf檔
                            <br><a href='tools/screenshot.exe' >截圖軟體，執行後可框選，框選後點磁片圖示即可存檔 </a></font><BR><br>
                            </font>
                        </td>
                    </tr>
                </table>
            </FORM>
            <form name="form2" id="form2" method="post" action="<?=site_url('/question/qcutpic')?>">
            	<input type="hidden" name="src" id="src">
                <input type="hidden" name="type" id="type" value="<?=$type?>">
                <input type="hidden" name="csrf_token" value="<?=$this->security->get_csrf_hash()?>">
            </form>
		</div>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
<?=$post?>
$('.set_all', parent.document).css('margin','2% auto');
$('.set_all', parent.document).css('width','857');
$('#que_pic', parent.document).attr('width','900').attr('height','320');
$(function () {
    var bar = $('.bar');
    var percent = $('.percent');
    var msg = $('#msg');
    //$("#fileupload").wrap("<form id='myupload' action='action.php' method='post' enctype='multipart/form-data'></form>");
    $("#qmg").change(function(){
        $("#form1").ajaxSubmit({
            dataType:  'json',
            beforeSend: function() {

            },
            uploadProgress: function(event, position, total, percentComplete) {
                msg.html('過程中請勿任意關閉或重整網頁，以免檔案處理失敗<br>');
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html('上傳進度：'+percentVal);
                if (percentComplete=100){
                	percent.html('上傳成功。處理中...');
                }
            },
            success: function(data) {
                document.getElementById('src').value = data.src;
            	$('#form2').submit();
            },
            error:function(xhr){
                percent.html(xhr.responseText);
                bar.width('0');
            }
        });
    });
});
</script>