<head>
    <link rel="shortcut icon" href="icon.png">
    <meta charset="UTF-8">
    <title>MyGrades</title>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="apple-touch-icon-precomposed" href="icon.png">
</head>
<body>
<div id="wrapper">
    <!--
        希望lmx大佬不要再跟我吐槽安全性的问题了……
        用GET把密码写在表头里是为了方便大家把本网站加入收藏夹吗(oﾟvﾟ)ノ
    -->
    <div v-for="(item, index) in courses" style="font-family:'Calibri';color: white">
        <div  v-on:click="changeDisplayMode(index)" v-bind:style="{ 'background-color': primaryColorList[index]}" style="font-size:50px; padding: 10px">
            <p >{{index+1}} {{item[0]}} <br>{{item[1]}}<br></p>
            <br>
        </div>
        <div  v-show="showing[index]" v-bind:style="{'background-color': secondaryColorList[index]}">
            <br>
            <span v-for="(assignment,index) in item[2]" style="font-size:30px; padding: 10px">
                    <span v-html="assignment">
                    </span>
                    <br>
                </span>
            <br>
        </div>
    </div>
    <script>
        var vm = new Vue({
            el: '#wrapper',
            data: {
                courses:<?php
                    require_once 'curl.php';
                    $curl = new Curl;
                    $UserName = $_GET["UserId"];
                    $Password = $_GET["Password"];
                    $url = 'http://ams.bhsfic.com/system/login/doLogin?email='.$UserName.'&userPwd='.$Password;
                    $response = $curl->get($url);
                    $url = "http://ams.bhsfic.com/student/courseclass/studentCourseLists";
                    $response = $curl->get($url);
                    $pattern = "/student\/courseclass\/gradedetail\/gradeDetailPage\/[0-9]+/";
                    preg_match_all ($pattern , $response,$matches);
                    $matches = $matches[0];



                    $json_object = [];
                    function my_sort($a,$b)
                    {
                        preg_match_all ( "/[0-9]{4}-[0-9]{2}-[0-9]{2}/" , $a.$b, $two_pk);
                        if ($two_pk[0][0]==$two_pk[0][1]) return 0;
                        return ($two_pk[0][0]<$two_pk[0][1])?1:-1; //时间晚的放在前面
                    }
                    foreach ($matches as $i){
                        $url = "http://ams.bhsfic.com/" . $i;
                        $response = $curl->get($url);
                        $pattern = "/[A-F]\+*\-* \([0-9]+%\)/";//
                        preg_match_all ( $pattern , $response, $grade);
                        if ($grade[0][0]!=""){
                            $pattern = "/10px;\" >[\S ]*/";//
                            preg_match_all ( $pattern , $response, $subjectName);
                            $subjectName = substr($subjectName[0][0],9);
                            $pattern = "/<td><a onclick=\"viewAssignmentDetail\(this\)\" >[\S ]*<\/a><\/td>
												<td> [0-9]{4}-[0-9]{2}-[0-9]{2} <\/td>
												<td> [\S]*&nbsp;\/&nbsp;[\S]*? <\/td>/";
                            preg_match_all ( $pattern , $response, $assignments);
                            usort($assignments[0],"my_sort");
                            $json_object[]=[$subjectName,$grade[0][0],$assignments[0]];
                        }
                    }



                    $url = "http://ams.bhsfic.com/system/login/loginOut";
                    $curl->get($url);

                    # 以下仅供统计数据使用，不会侵犯用户隐私

                    #以下为数据库使用常量

                    if ($_GET["UserId"]!="#BLOCKED"){
                        $servername = "#BLOCKED";
                        $username = "#BLOCKED";
                        $password = "#BLOCKED";
                        $dbname = "#BLOCKED";

// 创建连接
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        $sql = "UPDATE `ClickNumber` SET `number`=number+1 WHERE `id`=1";

                        $conn->query($sql) ;

                        $conn->close();
                    }


                    # LOG 1.1
                    #
                    # 修复了如果老师在作业介绍中使用换行符则无法正确匹配的问题
                    #
                    # LOG 1.2
                    #
                    # 如果是测试登录登录则不会触发 ClickNumber 的计数
                    #
                    # LOG 1.3:
                    #
                    # Updated To Vue
                    # LOG 1.4:
                    #
                    #
                    #



                    #以下是HTML本体
                    echo json_encode($json_object);
                    ?>,
                showing:[false,false,false,false,false,false,false,false,false,false,false,false],
                primaryColorList: ["#ba2636","#752100","#69821b","#1e50a2","#544a47","#f39800","#674196","#fcc800",'#66a6ee'],
                secondaryColorList: ["#b94047","#6c3524","#7b8d42","#3e62ad","#433d3c","#f6ad49","#7058a3","#ffdb4f",'#32ab2b']
            },
            methods: {
                changeDisplayMode: function (index) {
                    Vue.set(vm.showing, index, !vm.showing[index])
                }
            }

        })
    </script>
</div>
</body>
