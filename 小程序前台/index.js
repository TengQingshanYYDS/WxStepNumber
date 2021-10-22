Page({
  data: {
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    openId:0,
    stepList:{},
    syncText:'',
    startDate:'',
    finalDate:'',
    totalsteps:'',
    totalSteps_hidden:0,
    syncText_hidden:0,
    syncData_hidden:0,
    notice_hidden:0,
    noticeText:"",
 
  },
 
get3rdSession: function () {
    let that = this
    wx.request({
      url: '你的网站/test.php',
      data: {
        encryptedData: that.data.encryptedData,
        iv: that.data.iv,
        code: that.data.code,
      },
      method: 'GET', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
      success: function (res) {
 
        // 更新openId的值
        that.setData({
          openId: res.data.openid
        }); 
        
 
        //输出今天步数
        
        let stepList = res.data.sp.stepInfoList
        
        //console.log(stepList)
        that.setData({
          stepList: stepList,
        }); 
 
        console.log(stepList)
      },         
    }) 
  },
 
 onLoad: function () {
    let that = this
 
 
    wx.login({
      success: function (res) {
        let code = res.code
        that.setData({ code: code })
 
            wx.getWeRunData({//解密微信运动
              success(res) {
                const wRunEncryptedData = res.encryptedData
                that.setData({
                  encryptedData: wRunEncryptedData
                })
                that.setData({ iv: res.iv })
                that.get3rdSession()//解密请求函数 
              },
              
              fail: function (res) {
                if (res.errMsg == 'getWeRunData:fail auth deny'){
                  wx.showModal({
                    title: '提示',
                    content: '获取微信运动步数，需要开启计步权限',
                    success: function (res) {
                      if (res.confirm) {
                        //跳转去设置
                        wx.openSetting({
                          success: function (res) {
                          }
                        })
                      } else {
                        //不设置
                      }
                    }
                  })
                }
                else {
                  console.log(res.errMsg)
                  wx.showModal({
                    title: '提示',
                    content: '未开通微信运动，请关注“微信运动”公众号后重试',
                    showCancel: false,
                    confirmText: '知道了'
                  })
                  }
              }
              
            })
      }
    })
  },