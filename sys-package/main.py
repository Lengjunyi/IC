# /usr/bin/env python
# -*- coding: UTF-8 -*-

import requests

UserName = input("Please input your Username")
Password = input("Please input your Password")

s = requests.session()
login = s.get('http://ams.bhsfic.com/system/login/doLogin?email=' + UserName + '&userPwd=' + Password)
# 一般登陆会跳转到主页的日历页面，这里使用一个简单的方法来鉴别登陆成功与否
if "calendar" not in str(login.text.encode("utf-8")):
    print("Unable to login. Please check your username or your web connection.")
    exit()
else:
    print("Successfully login.")

# requests包没什么难度，后面我就不写了，自由发挥即可
# 这里提供几个有用的接口，不过请不要乱用[滑稽]

# 更改所在学期
# type：post
# url: http://ams.bhsfic.com/system/setSystemsSemsterIds
# data:{"semsIds": 17}
# comment: Id number should be found when you shenchayuansu(F12).

# 按照 用户名/ID 找相似用户
# type： post
# url: http://ams.bhsfic.com/account/messages/queryByNameLike
# data: {"acceptName": ""}
# comment: This include teachers and students, and test accounts

# 给某个人发信息
# type：post
# url: http://ams.bhsfic.com/account/messages/sendMsg
# data:{"currentMsg":{"acceptid":null,"acceptstate":2,"content":"Any word","id":600,"senddate":"2019-02-27 22:48:27","sendid":600,"sendstate":0}}
# comment: no use

# Withdraw A Course
# type：post
# url: http://ams.bhsfic.com/student/curriculavariable/cancelCourseSelected
# data:{"courseId" :  i}
# alert: may not work well if you don't first setSystemsSemsterIds
