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
