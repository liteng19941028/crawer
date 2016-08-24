<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>职位信息采集</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
<div>
    <input id="num" placeholder="从此id开始抓取" type="number">
    <input type="button" onclick="start()" value="开始抓取"/>
    <input type="button" onclick="stop()" value="停止抓取"/>
</div>
    <table id="box" border="1" style="margin-top:50px;">
        <tr>
            <th>ID</th>
            <th>标题</th>
            <th>地区</th>
            <th>薪资</th>
            <th>网址</th>
            <th>要求经验</th>
            <th>要求学历</th>
            <th>招聘人数</th>
            <th>发布时间</th>
            <th>详细地址</th>

            <th>公司名称</th>
            <th>公司性质</th>
            <th>公司规模</th>
            <th>所属行业</th>
        </tr>
    </table>
</body>
<script>
    function start(){
        var id = parseInt($('#num').val())
        var open = 1;
        craw(id);
    }

    function stop(){
        open = 0;
    }

    function craw(id){
        $.ajax({
            url:'http://www.crawer.com/jobs/wuyijob?id=' + id,
            datatype:'json',
            success:function(e){
                e = JSON.parse(e);
                if(!(isNaN(e.id)|| e.id == null || e.id =='')){
                    var tr = $('<tr></tr>');
                    $(tr).html("<td>"+ e.id+"<\/td><td>"+ e.title+"<\/td><td>"+ e.place+"<\/td><td>"+ e.str_salary+"<\/td><td>"+
                            e.website+"<\/td><td>"+ e.experience+"<\/td><td>"+ e.education+"<\/td><td>"+ e.people_cnt
                            +"<\/td><td>"+ e.show_time+"<\/td><td>"+ e.detail_address+"<\/td><td>"+ e.company
                            +"<\/td><td>"+ e.company_type+"<\/td><td>"+ e.company_people+"<\/td><td>"+ e.bussiness);
                    $('#box').append(tr);
                }
                $('#num').val(id);
                id ++;
                if(open) craw(id);
            }
        })
    }
</script>
</html>