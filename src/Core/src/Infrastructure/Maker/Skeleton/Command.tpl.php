<?php echo "<?php declare(strict_types=1);\n";
$domain = $domain ?? '';
$action = $action ?? '';
?>

namespace <?php echo $domain; ?>\Application\Command\<?php echo $action; ?>;

final class <?php echo $action; ?>Command
{
    function __construct(){}
}
