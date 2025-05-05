<?php
$projectPath = "C:\\Users\\VAIBHAVI\\Desktop\\cloned alocracy\\Alocracy";
$workingDir = "C:\\Users\\VAIBHAVI\\Desktop\\cloned alocracy\\Alocracy\\voter_chatbot";
$script = "app.py";

// Command to change directory, then run Python in background
$command = "cd /d \"$workingDir\" && start /B python \"$projectPath\\$script\"";
shell_exec($command);

// Give it a second to start
sleep(2);

// Redirect to the chatbot (running on its own port, like 5001)
header("Location: http://localhost:5001"); // Adjust port if different
exit;
?>
