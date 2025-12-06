# HPlus App（测试示例项目）

用于本地验证 HPlus 4.0 插件（route / validate / swagger）的示例项目。

## 环境要求

- PHP ≥ 8.1
- Hyperf ≥ 3.1
- 扩展：swoole、json、mbstring、pcntl

## 依赖安装

```bash
composer install
```

## 运行

```bash
php bin/hyperf.php start
```

启动后访问：
- 示例接口：`http://localhost:9501/test`
- Swagger 文档（依赖 swagger 插件）：`http://localhost:9501/swagger`

## 相关插件版本

| 插件 | 版本 | 说明 |
|------|------|------|
| hyperf-plus/route | ^4.0 | 路由 4.0（kebab-case、静态路由优先） |
| hyperf-plus/validate | ^4.0 | 验证 4.0（FormRequest、Query/Body 分离） |
| hyperf-plus/swagger | ^4.0 | Swagger 4.0（懒加载+缓存，OpenAPI 3.1.1） |

## 常用命令

```bash
# 启动服务
php bin/hyperf.php start

# 运行测试
composer test
```

## 注意

本项目仅用于 4.0 功能验证，不建议直接用于生产。
