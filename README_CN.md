# Web-based-IM 即时通讯系统

## 项目简介
Web-based-IM 是一个基于Web的即时通讯系统，提供实时聊天、在线状态显示、未读消息提醒等功能。本项目采用现代化的Web技术栈，为用户提供流畅的即时通讯体验。

## 功能特点
- 实时消息传递
- 用户在线状态实时显示
- 未读消息计数
- 表情符号支持
- 用户头像显示（基于用户名生成）
- 响应式界面设计
- 安全的用户认证机制

## 技术栈
### 后端
- PHP 7.4+
- ThinkPHP 6.0
- MySQL 5.7+

### 前端
- HTML5
- CSS3
- JavaScript (ES6+)
- jQuery
- Emoji-Mart（表情包支持）

## 关键技术实现

### 1. 实时通讯机制
- 采用轮询机制实现消息实时更新
- 通过后端API定期检查新消息
- 优化的数据库查询确保性能

### 2. 用户在线状态
- 采用心跳机制检测用户在线状态
- 30秒超时机制自动标记离线状态
- 实时更新用户状态显示

### 3. 消息处理
- 消息实时发送和接收
- 支持表情符号输入
- 消息时间戳显示
- 未读消息统计

### 4. 安全性
- 用户认证和会话管理
- SQL注入防护
- XSS攻击防护
- CSRF令牌验证

## 安装指南

### 环境要求
- PHP >= 7.4
- MySQL >= 5.7
- Composer
- Apache/Nginx

### 安装步骤

1. 克隆项目
```bash
git clone https://github.com/polaris2019/Web-based-IM.git
cd Web-based-IM
```

2. 安装依赖
```bash
composer install
```

3. 配置数据库
- 复制 `.env.example` 为 `.env`
- 修改数据库配置信息

4. 初始化数据库
```bash
php think migrate:run
```

5. 启动服务
```bash
php think run
```

## 使用指南

### 1. 注册/登录
- 访问系统首页进行注册
- 使用注册的账号密码登录

### 2. 聊天功能
- 在左侧用户列表选择聊天对象
- 在输入框输入消息
- 点击发送或按回车键发送消息
- 点击表情按钮插入表情

### 3. 状态查看
- 绿色圆点表示用户在线
- 红色圆点表示用户离线
- 未读消息数显示在用户名旁

## 项目结构
```
Web-based-IM/
├── app/                    # 应用目录
│   ├── controller/        # 控制器
│   ├── model/            # 数据模型
│   ├── middleware/       # 中间件
│   └── view/             # 视图文件
├── config/                # 配置文件
├── public/                # 公共资源
├── route/                 # 路由配置
└── vendor/                # 依赖包
```

## 开发建议
1. 定期检查并更新依赖包
2. 遵循 PSR 规范进行代码编写
3. 注意代码注释和文档维护
4. 进行安全性测试

## 贡献指南
1. Fork 本仓库
2. 创建特性分支
3. 提交更改
4. 发起 Pull Request

## 许可证
本项目采用 MIT 许可证，详情请参见 [LICENSE](LICENSE) 文件。

## 联系方式
- 项目维护者：[Jiantao Lu]
- 邮箱：[Jiantao.Lu@gmail.com]
- GitHub：[https://github.com/polaris2019/Web-based-IM]

## 致谢
感谢所有为本项目提供支持和帮助的贡献者。
