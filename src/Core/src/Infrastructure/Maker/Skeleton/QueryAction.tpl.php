<?php echo "<?php declare(strict_types=1);\n";
$domain = $domain ?? '';
$action = $action ?? '';
?>

namespace <?php echo $domain; ?>\Application\Query\<?php echo $action; ?>;

use Shared\Application\Action\ActionInterface;

final class <?php echo $action; ?> implements ActionInterface
{
    function __construct(){}

    function __invoke(){}
}
