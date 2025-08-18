<?php
/**
 * @var array $versions
 */
?>
<?php echo "<?php\n" ?>

namespace Arokettu\IsResource;

<?php foreach ($versions as $version): ?>
if (\PHP_VERSION_ID >= <?php echo $version ?>) {
    require __DIR__ . '/ResourceMap<?php echo $version ?>.php';
    \class_alias('Arokettu\\IsResource\\ResourceMap<?php echo $version ?>', 'Arokettu\\IsResource\\ResourceMap');
    return;
}

<?php endforeach; ?>
require __DIR__ . '/ResourceMap50000.php';
\class_alias('Arokettu\\IsResource\\ResourceMap50000', 'Arokettu\\IsResource\\ResourceMap');

if (\false) {
    /**
     * @internal
     * @generated
     */
    final class ResourceMap
    {
        /**
         * @return array
         */
        public static function map()
        {
            throw new \LogicException('This class should never be loaded');
        }
    }
}
