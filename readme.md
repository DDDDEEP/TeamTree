## 项目概述

* 产品名称：汇考平台 HK-platform
* 项目代号：huikao
* 官方地址：https://code.aliyun.com/372271602/huikao

<br>

汇考平台 是一个针对社会化考试的服务平台，平台包含社考网、监考网和后台管理系统三部分。
- 社考网：基于 **社考网微信公众号** 和 **社考网微信小程序** 面向参加社会化考试的考生，提供线上报考、电子准考证、考场导航、成绩查询服务。
- 监考网：基于 **监考网微信公众号** 面向监考人员，提供监考招募、报名、审核、通知、劳务费发放等功能。
- 后台管理系统：面向考务团队，提供在线化考务功能，提高每场考试活动的运作效率。

## 功能如下

- 待定

## 运行环境要求

- Nginx 1.8+
- PHP 7.1+
- Mysql 5.7+


<br>

## 开发环境部署/安装

本项目代码使用 PHP 框架 [Laravel 5.5](https://d.laravel-china.org/docs/5.5/) 开发，本地开发环境使用 [Laravel Homestead](https://d.laravel-china.org/docs/5.5/homestead)。

下文将在假定读者已经安装好了 Homestead 的情况下进行说明。如果您还未安装 Homestead，可以参照 [Homestead 安装与设置](https://laravel-china.org/docs/5.5/homestead#installation-and-setup) 进行安装配置。
<br>

### 基础安装

#### 1. 克隆源代码

克隆 `larabbs` 源代码到本地：

    > git clone https://code.aliyun.com/372271602/huikao

#### 2. 配置本地的 Homestead 环境

1). 运行以下命令编辑 Homestead.yaml 文件：

```shell
vim Homestead.yaml
```

2). 加入对应修改，如下所示：

```
folders:
    - map: ~/my-path/huikao # 你本地的项目目录地址
      to: /home/vagrant/huikao

sites:
    - map: huikao.test
      to: /home/vagrant/huikao/public

databases:
    - huikao
```

3). 应用修改

修改完成后保存，然后执行以下命令应用配置信息修改，并重启虚拟机：

```shell
vagrant provision && vagrant reload`
```


#### 3. 安装扩展包依赖

	composer install

#### 4. 生成配置文件

```
cp .env.example .env
```

你可以根据情况修改 `.env` 文件里的内容，如数据库连接、缓存、邮件设置等：

```
APP_URL=http://larabbs.test
...
DB_HOST=localhost
DB_DATABASE=huikao
DB_USERNAME=homestead
DB_PASSWORD=secret

DOMAIN=.huikao.test
```

#### 5. 生成数据表及生成测试数据

在 Homestead 的网站根目录下运行以下命令

```shell
$ php artisan migrate --seed
```

初始的用户角色权限已使用数据迁移生成。

#### 7. 生成秘钥

```shell
php artisan key:generate
```

#### 8. 配置 hosts 文件

    echo "192.168.10.10   huikao.test" | sudo tee -a /etc/hosts

#### 9. windows下安装croos-env（仅windows下需要此步骤）
    
    各在虚拟机与本地环境下分别运行一次：
    npm install cross-env -g



<br>

### 前端框架安装

1). 安装 node.js

直接去官网 [https://nodejs.org/en/](https://nodejs.org/en/) 下载安装最新版本。

2). 安装 Yarn

请安装最新版本的 Yarn —— http://yarnpkg.cn/zh-Hans/docs/install

3). 安装 Laravel Mix

```shell
yarn install
```

4). 编译前端内容

```shell
// 运行所有 Mix 任务...
npm run dev

// 运行所有 Mix 任务并缩小输出..
npm run production
```

5). 监控修改并自动编译

```shell
npm run watch

// 在某些环境中，当文件更改时，Webpack 不会更新。如果系统出现这种情况，请考虑使用 watch-poll 命令：

npm run watch-poll

// 注：若需要在windows下的本地bash上运行npm run xxx，则需要在本地重装一次node-bass扩展：

npm rebuild node-sass
npm update

```

### 链接入口

* 首页地址：http://huikao.test/
* 管理后台：http://huikao.test/admin

管理员账号密码如下:

```
username: admin
password: admin
```

至此, 安装完成 ^_^。

<br>

## 服务器架构说明
- 暂无


## 扩展包使用情况
| 扩展包 | 一句话描述 | 本项目应用场景 |
| --- | --- | --- | --- | --- | --- | --- | --- |
| [overtrue/laravel-wechat](https://github.com/overtrue/laravel-wechat) | 微信开发第三方SDK | 用于接入微信公众号 |
| [sentsin/layui](https://github.com/sentsin/layui) | Layui前端样式框架 | 快速调用各种现成样式组件 |
| [maatwebsite/excel](https://github.com/Maatwebsite/Laravel-Excel/tree/2.1) | Laravel的Excel处理工具（v2.1） | 实现Excel导入导出及处理 |
| [orangehill/iseed](https://github.com/orangehill/iseed) | Laravel的seeder生成器 | 将数据库数据导出并生成seeder文件 |
| [doctrine/dbal](https://github.com/doctrine/dbal) | Laravel的migration管理拓展 | 可通过migration修改数据库字段 |



## 自定义 Artisan 命令
- 暂无


## 队列清单
- 暂无
