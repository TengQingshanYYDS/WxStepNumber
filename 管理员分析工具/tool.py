import urllib.request
import os
import pandas as pd


# 先把所有步数csv文件下载到本地
# 可以通过服务器端的api获取到所有文件名，接着python遍历文件名来下载

import urllib.request

url = "步数csv文件网址"
f = urllib.request.urlopen(url)
data = f.read()
with open("2019-02-23","wb") as code:
    code.write(data)


# 接着遍历所有已经下载的csv文件，将他们导入到Excel文件中
# 一个日期一个sheet

# \\n防止转义为换行
newdir = 'G:\编程代码\python代码\表格\\new'
list = os.listdir(newdir)  # 列出文件夹下所有的目录与文件

writer = pd.ExcelWriter('步数.xlsx')

for i in range(0,len(list)):
    data = pd.read_csv(list[i],encoding="gbk", index_col=0)
    data.to_excel(writer, sheet_name=list[i])


writer.save()
