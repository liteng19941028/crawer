<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文章采集</title>
</head>
<body>
    <div>
        <h1>搜房网</h1>
        <table>
            <tr>
                <form action="/crawer/souFangByCity">
                    <td>采集天数:<input width="20px" name="d" value="1"></td>
                    <td>
                        <select name="u">
                            <option value="shanghai">上海</option>
                            <option value="hangzhou">杭州</option>
                            <option value="suzhou">苏州</option>
                            <option value="shenzhen">深圳</option>
                            <option value="nanjing">南京</option>
                            <option value="guangzhou">广州</option>
                            <option value="beijing">北京</option>
                        </select>
                    </td>
                    <td><input type="submit" value="开始采集"></td>
                </form>
            </tr>
        </table>
    </div>
    <div>
        <h1>楼盘网</h1>
        <table>
            <tr>
                <form action="/crawer/loupanWang">
                    <td>采集天数:<input width="20px" name="d" value="1"></td>
                    <td>
                        <select name="u">
                            <option value="shanghai">上海</option>
                            <option value="hangzhou">杭州</option>
                            <option value="suzhou">苏州</option>
                            <option value="shenzhen">深圳</option>
                            <option value="nanjing">南京</option>
                            <option value="guangzhou">广州</option>
                        </select>
                    </td>
                    <td><input type="submit" value="开始采集"></td>
                </form>
            </tr>
        </table>
    </div>

    <div>
        <h1>房产新资讯</h1>
        <table>
            <tr>
                <form action="/crawer/houseNews">
                    <td>采集天数:<input width="20px" name="d" value="7"></td>
                    <td>
                    </td>
                    <td><input type="submit" value="开始采集">（每个星期一采）</td>
                </form>
            </tr>
        </table>
    </div>
</body>
</html>