&lt;?php

require_once dirname(__FILE__) . '/<?= $this->namespace ?>.php';
require_once dirname(__FILE__) . '/<?= $this->namespace ?>/Bootstrap.php';

<?= $this->namespace ?>_Bootstrap::<?= $this->kickoff ?>();

?&gt;