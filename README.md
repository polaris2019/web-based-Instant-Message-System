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
- SqlLite3 / MySQL 5.7+

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

# Web-based Instant Messaging System

A real-time instant messaging system built with ThinkPHP 6, featuring user authentication, real-time messaging, and a clean Bootstrap UI.

## Features

- User registration and authentication
- Real-time messaging between users
- Message history
- Online users list
- Clean and responsive UI using Bootstrap 5
- SQLite database for easy setup

## Requirements

- PHP >= 7.4
- Composer
- SQLite 3
- Web browser with JavaScript enabled

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd Web-based-IM
```

2. Install dependencies:
```bash
composer install
```

3. Configure the environment:
```bash
cp .example.env .env
```

4. Create the SQLite database:
```bash
mkdir -p database
touch database/database.sqlite
```

5. Run database migrations:
```bash
php think migrate:run
```

## Configuration

### Database Configuration
The system uses SQLite by default. The configuration is already set in `config/database.php`. If you need to modify any settings, you can edit this file.

### Environment Variables
Edit the `.env` file with your preferred settings:
```env
APP_DEBUG = true
APP_TRACE = false

[DATABASE]
TYPE = sqlite
DATABASE = database/database.sqlite
PREFIX = think_
```

## Running the Application

1. Start the development server:
```bash
php think run
```

2. Access the application:
- Registration: `http://localhost:8000/user/register`
- Login: `http://localhost:8000/user/login`
- Chat Interface: `http://localhost:8000/chat`

## System Structure

### Controllers
- `UserController`: Handles user registration, login, and profile management
- `MessageController`: Manages message sending and retrieval
- `ChatController`: Manages chat sessions and real-time updates

### Models
- `User`: User data model with authentication methods
- `Message`: Message data model with relationships

### Views
- `view/user/login.html`: User login interface
- `view/user/register.html`: User registration interface
- `view/chat/index.html`: Main chat interface

### Routes
All routes are defined in `route/app.php`:
- User routes (`/user/*`)
- Message routes (`/message/*`)
- Chat routes (`/chat/*`)

## Usage

1. Register a new account at `/user/register`
2. Log in with your credentials at `/user/login`
3. Once logged in, you'll be redirected to the chat interface
4. Select a user from the list to start chatting
5. Messages are sent in real-time and stored in the database

## Security Features

- Password hashing using PHP's built-in password_hash()
- Session-based authentication
- Input validation and sanitization
- CSRF protection (built into ThinkPHP 6)

## Development

### Adding New Features
1. Create new controllers in `app/controller/`
2. Add routes in `route/app.php`
3. Create corresponding views in `view/`

### Database Modifications
1. Create new migrations in `database/migrations/`
2. Run migrations: `php think migrate:run`

## Troubleshooting

### Common Issues

1. Database Connection Error
```bash
# Check database file permissions
chmod 666 database/database.sqlite
```

2. Server Not Starting
```bash
# Check if port 8000 is already in use
netstat -ano | findstr :8000
# Use a different port
php think run -p 8001
```

3. Composer Dependencies
```bash
# Clear composer cache
composer clear-cache
# Update dependencies
composer update
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request




