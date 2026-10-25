<?php
$items = scandir('.');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rootva File Explorer</title>
    <style>
        :root {
            --bg: #f0f4f8;
            --card: #ffffff;
            --text: #222;
            --hover: #e6f2ff;
            --icon: #0077cc;
        }
        body.dark {
            --bg: #121212;
            --card: #1e1e1e;
            --text: #f0f0f0;
            --hover: #2a2a2a;
            --icon: #4fc3f7;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            padding: 20px;
            transition: 0.3s ease;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--icon);
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .toggle-dark {
            text-align: right;
            margin-bottom: 10px;
        }

        .toggle-dark button {
            background: none;
            border: 1px solid var(--icon);
            color: var(--icon);
            padding: 5px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .toggle-dark button:hover {
            background-color: var(--hover);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 10px;
        }

        th {
            background-color: var(--icon);
            color: white;
        }

        tr:nth-child(even) {
            background-color: var(--card);
        }

        tr:hover {
            background-color: var(--hover);
        }

        a {
            text-decoration: none;
            color: var(--icon);
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .container {
                width: 95%;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="toggle-dark">
            <button onclick="toggleDark()">🌙 Toggle Dark Mode</button>
        </div>

        <h2>📁 Rootva ফোল্ডারের কন্টেন্ট</h2>

        <input type="text" id="searchBox" onkeyup="filterTable()" placeholder="🔍 ফাইল/ফোল্ডার সার্চ করুন...">

        <table id="fileTable">
            <thead>
                <tr>
                    <th>নাম</th>
                    <th>টাইপ</th>
                    <th>সাইজ</th>
                    <th>সর্বশেষ আপডেট</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($items as $item) {
                    if ($item === '.' || $item === '..') continue;

                    $isDir = is_dir($item);
                    $icon = $isDir ? '📁' : '📄';
                    $type = $isDir ? 'Folder' : 'File';
                    $href = $isDir ? "$item/" : $item;

                    // Size
                    $size = $isDir ? '-' : filesize($item);
                    $sizeStr = '-';
                    if (!$isDir) {
                        if ($size >= 1048576) {
                            $sizeStr = number_format($size / 1048576, 2) . ' MB';
                        } elseif ($size >= 1024) {
                            $sizeStr = number_format($size / 1024, 2) . ' KB';
                        } else {
                            $sizeStr = $size . ' B';
                        }
                    }

                    // Modified date
                    $date = date("Y-m-d H:i:s", filemtime($item));

                    echo "<tr>
                            <td><a href=\"$href\">$icon $item</a></td>
                            <td>$type</td>
                            <td>$sizeStr</td>
                            <td>$date</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function filterTable() {
            const input = document.getElementById("searchBox").value.toLowerCase();
            const rows = document.querySelectorAll("#fileTable tbody tr");

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? "" : "none";
            });
        }

        function toggleDark() {
            document.body.classList.toggle("dark");
            localStorage.setItem("darkMode", document.body.classList.contains("dark") ? "on" : "off");
        }

        window.onload = function () {
            if (localStorage.getItem("darkMode") === "on") {
                document.body.classList.add("dark");
            }
        };
    </script>
</body>
</html>
