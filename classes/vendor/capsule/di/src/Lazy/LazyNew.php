<?php
declare(strict_types=1);

namespace Capsule\Di\Lazy;

use Capsule\Di\Container;

class LazyNew implements LazyInterface
{
    protected $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __invoke(Container $container) /* : mixed */
    {
        return $container->new($this->id);
    }
}
