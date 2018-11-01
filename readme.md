### 环境记录
Laravel版本： 5.7

PHP版本：7.13
...

(基于homestead虚拟机的环境)

### 运行方式
1. clone 该项目
2. composer install
3. 根据 .env.example 填写 env 环境配置 (并生成APP_KEY)
4. `php artisan migrate` 执行数据库迁移文件
5. 生成jwt密钥：`php artisan jwt:secret`

#### 目前接口
- [后台](#后台)
  - [用户](#用户)

#### 后台（*URL前缀：admin*）
  ###### 用户
     1. 登录接口：
        method: POST
        url: '/login'
        body: {
          "email": "{email}",
          "password": "{password}"
        }
