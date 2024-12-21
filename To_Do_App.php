<?php
$file = 'Item_File';

function loadTasks($file) {
    if (file_exists($file)) {
        $tasks = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return $tasks;
    }
    return [];
}

function saveTasks($file, $tasks) {
    file_put_contents($file, implode(PHP_EOL, $tasks));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tasks = loadTasks($file);

    if (isset($_POST['add_task'])) {
        $task = trim($_POST['task']);
        if (!empty($task)) {
            $tasks[] = $task;
            saveTasks($file, $tasks);
        }
    } elseif (isset($_POST['delete_task'])) {
        $index = $_POST['task_index'];
        if (isset($tasks[$index])) {
            unset($tasks[$index]);
            $tasks = array_values($tasks); 
            saveTasks($file, $tasks);
        }
    }
}



$tasks = loadTasks($file);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #c0dfa3;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px #178d2d;
        }
        h1 {
            text-align: center;
            color:#025b13;
        }
        form {
            display: flex;
            margin-bottom: 20px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            color: #025b13;
        }
        button {
            padding: 15px 30px;
            background:rgba(24, 80, 1, 0.81);
            color: #fff;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }
        button.delete {
            padding: 15px 40px;
            background:rgb(151, 0, 0);
           
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
            background: #c0dfa3;
            margin-bottom: 5px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>To-Do App</h1>
        <form method="POST">
            <input type="text" name="task" placeholder="Enter a new task" required>
            <button type="submit" name="add_task">Add Task</button>
        </form>
        <ul>
            <?php foreach ($tasks as $index => $task): ?>
                <li>
                    <?= htmlspecialchars($task) ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="task_index" value="<?= $index ?>">
                        <button type="submit" name="delete_task" class="delete">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
