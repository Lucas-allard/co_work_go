<?php echo "<?php declare(strict_types=1);\n";
$domain = $domain ?? ''; ?>

namespace <?php echo $domain; ?>\config;

use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

final class DoctrineConfig
{
    public static function configure(EntityManagerConfig $emDefault): void
    {
        $emDefault->mapping('<?php echo $domain; ?>')
        ->type('php')
        ->dir(dirname(__DIR__).'/Infrastructure/Entity')//self::getDirectoryPath())
        ->prefix('<?php echo $domain; ?>')
        ;
    }
}
