# Hyperf 官方 Docker 测试环境

## 环境概述

使用官方 Hyperf Docker 镜像成功创建了完整的测试环境，包含以下服务：

### 服务列表

1. **Hyperf 应用** (hyperf/hyperf:7.4-alpine-v3.11-swoole)
   - 端口: 9501
   - 访问地址: http://localhost:9501
   - 包含 HPlus 后台管理系统

2. **MySQL 8.0**
   - 端口: 3306
   - 数据库: hyperf
   - 用户名: hyperf
   - 密码: hyperf123
   - 自动导入初始化数据: 20201215.sql

3. **Redis 6.2**
   - 端口: 6379
   - 用于缓存和队列

4. **phpMyAdmin**
   - 端口: 8080
   - 访问地址: http://localhost:8080
   - 用于数据库管理

## 项目特性

- **框架**: Hyperf 2.1
- **PHP 版本**: 7.4
- **管理后台**: HPlus 后台管理系统
- **认证系统**: 内置用户认证
- **API 文档**: Swagger 支持
- **缓存**: Redis 缓存
- **队列**: 异步队列支持

## 快速启动

```bash
# 启动所有服务
sudo docker compose up -d

# 查看服务状态
sudo docker compose ps

# 查看日志
sudo docker compose logs hyperf

# 停止服务
sudo docker compose down
```

## 访问地址

- **主应用**: http://localhost:9501
- **数据库管理**: http://localhost:8080
- **API 文档**: http://localhost:9501/swagger (如已配置)

## 数据库连接

```env
DB_DRIVER=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=hyperf
DB_USERNAME=hyperf
DB_PASSWORD=hyperf123
```

## Redis 连接

```env
REDIS_HOST=redis
REDIS_PORT=6379
REDIS_DB=0
```

## 管理后台

默认访问会重定向到 `/auth` 登录页面：
- 系统名称: HPlus 后台管理系统
- 登录地址: http://localhost:9501/auth

## 开发工具

项目包含以下开发工具：
- PHPUnit 测试框架
- PHP-CS-Fixer 代码格式化
- PHPStan 静态分析
- Hyperf Devtool 开发工具

## 测试状态

✅ Hyperf 应用正常启动
✅ HTTP 服务器响应正常
✅ 数据库连接成功
✅ Redis 连接正常
✅ 管理后台页面加载成功
✅ 依赖包安装完整

## 注意事项

1. 首次启动可能需要等待数据库初始化完成
2. 确保本地端口 9501、3306、6379、8080 未被占用
3. 如需修改配置，请编辑 `.env` 文件和 `docker-compose.yml`
4. 项目使用 PHP 7.4 版本的官方 Hyperf 镜像

## 故障排除

```bash
# 查看容器日志
sudo docker compose logs [service_name]

# 进入容器调试
sudo docker compose exec hyperf bash

# 重新构建并启动
sudo docker compose down && sudo docker compose up -d --build
```

---

**测试完成时间**: $(date)
**Docker 镜像**: hyperf/hyperf:7.4-alpine-v3.11-swoole
**状态**: ✅ 所有服务运行正常