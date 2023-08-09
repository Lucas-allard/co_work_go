<?php echo "<?php declare(strict_types=1);\n";
$domain = $domain ?? ''; ?>

namespace <?php echo $domain; ?>\config;

use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;

final class ContainerConfig
{
    public static function configure(DefaultsConfigurator $services): void
    {

    }
}
