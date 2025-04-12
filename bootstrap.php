<?php
$pathCoreFile = array_diff(scandir('core/'), ['.', '..']);
foreach ($pathCoreFile as $key => $value) {
  require "core/$value";
}
?>
