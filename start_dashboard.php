<?php
$pythonScriptPath = "C:\\Users\\VAIBHAVI\\Desktop\\cloned alocracy\\Alocracy\\dashboard.py";

// Command to start Python dashboard in background (Windows style)
$command = "start /B python \"$pythonScriptPath\"";
shell_exec($command);

// Wait a moment to let Python server start
sleep(2);

// Redirect to your dashboard
header("Location: http://localhost:5000");
exit;
?>

