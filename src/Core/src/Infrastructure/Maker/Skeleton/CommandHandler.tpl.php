<?php echo "<?php declare(strict_types=1);\n";
$domain = $domain ?? '';
$action = $action ?? '';
?>

namespace <?php echo $domain; ?>\Application\Command\<?php echo $action; ?>;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class <?php echo $action; ?>Handler implements MessageHandlerInterface
{
    function __construct(){}

    function __invoke(<?php echo $action; ?>Command $command){}
}
