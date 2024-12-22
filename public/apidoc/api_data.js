define({ "api": [
  {
    "type": "get",
    "url": "/api/v1/user/refresh",
    "title": "刷新jwt token",
    "description": "<p>刷新jwt token</p>",
    "group": "Auth",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "sampleRequest": [
      {
        "url": "/api/v1/user/refresh"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/AuthController.php",
    "groupTitle": "Auth",
    "name": "GetApiV1UserRefresh",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/oauth/login",
    "title": "第三方用户登录",
    "description": "<p>第三方用户登录，登录成功后会放回对应的jwt token</p>",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "openid",
            "description": "<p>OpenID</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/oauth/login"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/OAuthController.php",
    "groupTitle": "Auth",
    "name": "PostApiV1OauthLogin",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/user/login",
    "title": "用户登录",
    "description": "<p>用户登录，登录成功后会放回对应的jwt token</p>",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "username",
            "description": "<p>用户名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/user/login"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/AuthController.php",
    "groupTitle": "Auth",
    "name": "PostApiV1UserLogin",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/user/logout",
    "title": "用户登出",
    "description": "<p>用户登出 使令牌token失效。</p>",
    "group": "Auth",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "sampleRequest": [
      {
        "url": "/api/v1/user/logout"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/AuthController.php",
    "groupTitle": "Auth",
    "name": "PostApiV1UserLogout",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/user/register",
    "title": "用户注册",
    "description": "<p>用户注册，邮箱和用户名不能重复吗</p>",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "username",
            "description": "<p>用户名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "nickname",
            "description": "<p>昵称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/user/register"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/AuthController.php",
    "groupTitle": "Auth",
    "name": "PostApiV1UserRegister",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/user/register",
    "title": "用户注册",
    "description": "<p>用户注册，邮箱和用户名不能重复吗</p>",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "username",
            "description": "<p>用户名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "nickname",
            "description": "<p>昵称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/user/register"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/OAuthController.php",
    "groupTitle": "Auth",
    "name": "PostApiV1UserRegister",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/banner/detail",
    "title": "广告详情",
    "description": "<p>广告详情</p>",
    "group": "Banner",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>广告编号</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/banner/detail"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/BannerController.php",
    "groupTitle": "Banner",
    "name": "PostApiV1BannerDetail",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/banner/list",
    "title": "广告列表",
    "description": "<p>广告列表</p>",
    "group": "Banner",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "sampleRequest": [
      {
        "url": "/api/v1/banner/list"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/BannerController.php",
    "groupTitle": "Banner",
    "name": "PostApiV1BannerList",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/api/v1/user/change",
    "title": "修改密码",
    "description": "<p>忘记密码，修改密码</p>",
    "group": "Center",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "username",
            "description": "<p>用户名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/user/change"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/AuthController.php",
    "groupTitle": "Center",
    "name": "GetApiV1UserChange",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/user/center",
    "title": "账号信息",
    "description": "<p>账号信息，验证jwt 是否有效</p>",
    "group": "Center",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "sampleRequest": [
      {
        "url": "/api/v1/user/center"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/AuthController.php",
    "groupTitle": "Center",
    "name": "PostApiV1UserCenter",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/user/feedback",
    "title": "用户反馈",
    "description": "<p>用户注册，邮箱和用户名不能重复吗</p>",
    "group": "Feedback",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>反馈标题</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "content",
            "description": "<p>反馈内容</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>联系方式</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/user/feedback"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/OpinionController.php",
    "groupTitle": "Feedback",
    "name": "PostApiV1UserFeedback",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/news/detail",
    "title": "新闻详情",
    "description": "<p>世界太大了，我们该去看看</p>",
    "group": "News",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>新闻编号</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/news/detail"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/NewsController.php",
    "groupTitle": "News",
    "name": "PostApiV1NewsDetail",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/news/list",
    "title": "新闻列表",
    "description": "<p>世界太大了</p>",
    "group": "News",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/news/list"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/NewsController.php",
    "groupTitle": "News",
    "name": "PostApiV1NewsList",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/record/detail",
    "title": "扫码记录详情",
    "description": "<p>扫码记录详情</p>",
    "group": "Record",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>记录编号</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/record/detail"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/RecordController.php",
    "groupTitle": "Record",
    "name": "PostApiV1RecordDetail",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/record/list",
    "title": "扫码记录列表",
    "description": "<p>扫码记录列表</p>",
    "group": "Record",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "page",
            "description": "<p>当前页码</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/record/list"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/RecordController.php",
    "groupTitle": "Record",
    "name": "PostApiV1RecordList",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/scan/identify",
    "title": "扫码识别信息",
    "description": "<p>扫码识别信息</p>",
    "group": "Scan",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "user_id",
            "description": "<p>当前扫描用户编号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "picture",
            "description": "<p>base64加密后的图片信息</p>"
          }
        ]
      }
    },
    "sampleRequest": [
      {
        "url": "/api/v1/scan/identify"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/ScanController.php",
    "groupTitle": "Scan",
    "name": "PostApiV1ScanIdentify",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/v1/system/info",
    "title": "系统信息",
    "description": "<p>系统信息</p>",
    "group": "System",
    "permission": [
      {
        "name": "jwt",
        "title": "用户jwt权限验证token",
        "description": ""
      }
    ],
    "sampleRequest": [
      {
        "url": "/api/v1/system/info"
      }
    ],
    "version": "1.0.0",
    "filename": "App/Http/Controllers/Api/V1/SystemController.php",
    "groupTitle": "System",
    "name": "PostApiV1SystemInfo",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "defaultValue": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlLm1pbmcuY29tXC9hcGlcL3YxXC9zdHVkZW50XC9hdXRoXC9sb2dpbiIsImlhdCI6MTUzNDM5OTE5NSwiZXhwIjoxNTM2NTU5MTk1LCJuYmYiOjE1MzQzOTkxOTUsImp0aSI6InNDNG15YUVLZzkzRW4wbVkiLCJzdWIiOiI1NTQ2Mzg4NDk0NjgyNjk1NzEiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.PpThPbGaxSFXfs6eyWMKF2pchuy2q-XSkrGWlQ9QrrM",
            "description": "<p>auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "msg",
            "description": "<p>信息</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "error",
            "description": "<p>0 代表无错误 非0代表有错误</p>"
          },
          {
            "group": "Success 200",
            "type": "String[]",
            "optional": true,
            "field": "data",
            "description": "<p>有数据时返回数据，没有数据时不返回此字段</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "返回样例:",
          "content": "{\n\"error\":\"0\",\n\"msg\":\"成功\",\n\"data\":{...}\n}",
          "type": "json"
        }
      ]
    }
  }
] });
