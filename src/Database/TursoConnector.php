<?php

declare(strict_types=1);

namespace Mis3085\Turso\Database;

use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;

class TursoConnector extends Connector implements ConnectorInterface
{
    /**
     * Establish a database connection.
     *
     * @return TursoPDO
     */
    public function connect(array $config)
    {
        $options = $this->getOptions($config);

        return new TursoPDO($config, $options);
    }
}
