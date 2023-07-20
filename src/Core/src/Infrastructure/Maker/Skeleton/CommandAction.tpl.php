<?php echo "<?php declare(strict_types=1);\n";
$domain = $domain ?? '';
$action = $action ?? '';
?>

namespace <?php echo $domain; ?>\Application\Command\<?php echo $action; ?>;

use Shared\Application\Action\ActionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class <?php echo $action; ?> implements ActionInterface
{
    function __construct(
        private MessageBusInterface $bus
    ){}

    function __invoke(<?php echo $action; ?>Command $command): void {
        $this->bus->dispatch($command);
    }
}
