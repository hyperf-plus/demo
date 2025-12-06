# HPlus App（4.0 体验示例）

用于快速体验 / 验证 HPlus 4.0 三个核心插件：`route`、`validate`、`swagger`。

## 主要亮点

- 🛣️ 路由 4.0：kebab-case URL、静态路由优先、精简 RESTful 映射
- ✅ 验证 4.0：Query/Body 分离，支持 FormRequest，移除旧 Validate 基类
- 📖 Swagger 4.0：懒加载 + 缓存，首访构建，后续极速返回
- 🔄 一注解三件事：路由注册 + 参数验证 + 文档生成 同步完成

## 预置接口（`/test`）

- `GET  /test`             首页说明页（列出示例与特性）
- `GET  /test/get-test`    Query 验证示例（page/size/keyword/status）
- `POST /test/post-test`   JSON 体验证示例（name/email/age）
- `POST /test/form-test`   表单验证示例（mode: form）

> 所有接口都可在 Swagger 中直接试用：`/swagger`

## 环境要求

- PHP ≥ 8.1
- Hyperf ≥ 3.1
- 扩展：swoole、json、mbstring、pcntl

## 快速开始

```bash
composer install
php bin/hyperf.php start
```

访问：
- 示例页：`http://localhost:9501/test`
- Swagger：`http://localhost:9501/swagger` （需安装 swagger 插件）

## 相关插件版本

| 插件 | 版本 | 说明 |
|------|------|------|
| hyperf-plus/route    | ^4.0 | kebab-case、静态路由优先 |
| hyperf-plus/validate | ^4.0 | Query/Body 分离，FormRequest |
| hyperf-plus/swagger  | ^4.0 | 懒加载+缓存，OpenAPI 3.1.1 |

## 常用命令

```bash
# 启动
php bin/hyperf.php start

# 测试
composer test
```

## 说明

本项目仅用于 4.0 功能验证，便于大家试用，不建议直接用于生产。
