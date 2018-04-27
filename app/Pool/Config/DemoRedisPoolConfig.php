<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Pool\Config;

use Swoft\Bean\Annotation\Bean;
use Swoft\Bean\Annotation\Value;
use Swoft\Redis\Pool\Config\RedisPoolConfig;

/**
 * DemoRedisPoolConfig
 *
 * @Bean()
 */
class DemoRedisPoolConfig extends RedisPoolConfig
{
    /**
     * @Value(name="${config.cache.demoRedis.db}", env="${REDIS_DEMO_REDIS_DB}")
     * @var int
     */
    protected $db = 0;

    /**
     * @Value(name="${config.cache.demoRedis.prefix}", env="${REDIS_DEMO_REDIS_PREFIX}")
     * @var string
     */
    protected $prefix = '';

    /**
     * @Value(name="${config.cache.demoRedis.uri}", env="${REDIS_DEMO_URI}")
     * @var array
     */
    protected $uri;

    /**
     * the name of pool
     *
     * @Value(name="${config.cache.demoRedis.name}", env="${REDIS_DEMO_NAME}")
     * @var string
     */
    protected $name = '';

    /**
     * @Value(name="${config.cache.demoRedis.provider}", env="${REDIS_DEMO_PROVIDER}")
     * @var string
     */
    protected $provider = '';

}