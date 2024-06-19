<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magefan\RocketJavaScript\Setup\Patch\Schema;

use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class ChangePath implements SchemaPatchInterface
{

    /**
     * @var SchemaSetupInterface
     */
    private $schemaSetup;

    /**
     * Constructor
     *
     * @param SchemaSetupInterface $schemaSetup
     */
    public function __construct(
        SchemaSetupInterface $schemaSetup
    ) {
        $this->schemaSetup = $schemaSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->schemaSetup->startSetup();
        $connection = $this->schemaSetup->getConnection();

        $table = $this->schemaSetup->getTable('core_config_data');

        $changedConfigurationFields = [
            'mfrocketjavascript/general/enable_deferred_javascript' => 'mfrocketjavascript/deferred_javascript/enabled',
            'mfrocketjavascript/general/disallowed_pages_for_deferred_js' => 'mfrocketjavascript/deferred_javascript/disallowed_pages_for_deferred_js',
            'mfrocketjavascript/general/ignore_deferred_javascript_with' => 'mfrocketjavascript/deferred_javascript/ignore_deferred_javascript_with',

            'mfrocketjavascript/general/enable_js_bundling_optimization' => 'mfrocketjavascript/javascript_bundling/enabled',
            'mfrocketjavascript/general/included_in_bundling' => 'mfrocketjavascript/javascript_bundling/included_in_bundling',
        ];

        foreach ($changedConfigurationFields as $oldPath => $newPath) {
            $connection->update(
                $table,
                ['path' => $newPath],
                ['path = ?' => $oldPath]
            );
        }

        $this->schemaSetup->endSetup();
    }

    /**
     * @return array
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }
}
