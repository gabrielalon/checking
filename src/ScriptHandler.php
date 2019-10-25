<?php

namespace N3ttech\Checking;

use Composer\Config;
use Composer\Script\Event;

class ScriptHandler
{
    /**
     * @param Event $event
     */
    public static function run(Event $event): void
    {
        /** @var Config $config */
        $config = $event->getComposer()->getConfig();
        $vendorPath = $config->get('vendor-dir');
        $rootPath = dirname($vendorPath);

        $sourcePath = implode(DIRECTORY_SEPARATOR, [
            $vendorPath,
            'n3ttech/checking/bin',
        ]);

        foreach (['.php_cs', 'makefile', 'phpstan.neon'] as $file) {
            if (true === file_exists($rootPath.DIRECTORY_SEPARATOR.$file)) {
                $event->getIO()->write(sprintf(
                    '<info>Skiping copy for "%s"</info>',
                    $sourcePath.DIRECTORY_SEPARATOR.$file
                ));

                continue;
            }

            copy(
                $sourcePath.DIRECTORY_SEPARATOR.$file,
                $rootPath.DIRECTORY_SEPARATOR.$file
            );

            $event->getIO()->write(sprintf(
                '<info>Creating copy for "%s" into "%s"</info>',
                $sourcePath.DIRECTORY_SEPARATOR.$file,
                $rootPath.DIRECTORY_SEPARATOR.$file
            ));
        }

        if (false === file_exists($rootPath.'/.gitignore')) {
            touch($rootPath.'/.gitignore');
        }

        $content = file_get_contents($rootPath.'/.gitignore');

        if (false === strpos($content, 'n3ttech/base')) {
            $content .= '###> n3ttech/base ###
vendor
.idea
.DS_Store
###> n3ttech/base ###;

###> n3ttech/checking ###
.php_cs.cache
###> n3ttech/checking ###';

            file_put_contents($rootPath.'/.gitignore', $content);
            $event->getIO()->write('<info>Updating .gitingore</info>');
        }
    }
}
