<?php if(isset($wxurl)&&!empty($wxurl)){?>
    <link rel="stylesheet" href="/static/css/lgb/title.css">
    <link rel="stylesheet" href="/static/css/publish/personal.publish.css">

    <section>
        <p class="title2">
            <a href="/user"><</a>
            <span>二维码支付</span>
        </p>
        <div class="panel-body">
            <div style="text-align: center;">
                <input type="hidden" id="orderno" value="<?php echo $orderno;?>"/>
                <img alt="扫码支付" src="<?php echo 'http://'.$localhost.'/pay/qrcode?data='.urlencode($wxurl);?>" style="width:200px;height:200px;"/>
            </div>
        </div>

    </section>
<?php }?>
<script>
    // 每半秒请求一次数据，然后判断，跳转，增加用户友好性
    $(function(){
        orderno = $('#orderno').val();
        start = self.setInterval("checkstatus(orderno)", 5000);
    });

    function checkstatus(order_no){
        if(order_no == undefined || order_no == ''){
            window.clearInterval(start);
        }
        else{
            $.ajax({
                url:"<?php echo '/pay/queryorder';?>",
                type:'POST',
                dataType:'json',
                data:{orderno:orderno,'uid':'<?php echo $uid; ?>','type':'<?php echo $type; ?>','wayid':'<?php echo $wayid; ?>','credits':'<?php echo $credits; ?>','cost':'<?php echo $cost; ?>'},
                error: function(){
                     alert('检测失败，请重试');
                },
                success:function(msg){
                    if(msg.trade_state == "SUCCESS") {
                        window.clearInterval(start);
                        if(msg.flag < 0){
                            alert(msg.info);
                        }else{
                            alert('支付成功');
                        }
                        location.href = "<?php echo '/user/center';?>";
                    }
                }
            });
        }
    }
</script>