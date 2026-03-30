<?php

declare(strict_types=1);

$success = \App\Core\Session::pullFlash('success');
$error = \App\Core\Session::pullFlash('error');
?>
<?php if ($success): ?>
    <div class="container flash flash--success" role="status"><?= e((string) $success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="container flash flash--error" role="alert"><?= e((string) $error) ?></div>
<?php endif; ?>
