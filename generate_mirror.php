<?php
ob_start();

$phpFiles = [
    'index.php',
    'about.php',
    'contact.php',
    'blog.php',
    'events.php',
    'admin/articles.php',
    'admin/create-event.php',
    'admin/create-post.php',
    'admin/events1.php',
    'admin/home.php',
    'admin/index.php',
    'admin/manage_event.php',
    'admin/manage.php'
];

$outputDir = __DIR__ . '/mirror_html';

// Ensure output directory exists
if (!file_exists($outputDir)) {
    mkdir($outputDir, 0777, true);
}

function generateMirror(array $files, string $outputDir)
{
    foreach ($files as $phpFile) {
        if (!file_exists($phpFile)) {
            echo "File not found: $phpFile\n";
            continue;
        }

        $baseName = basename($phpFile, '.php');
        $htmlPath = $outputDir . '/' . $baseName . '.html';

        ob_start();
        include $phpFile;
        $htmlContent = ob_get_clean();

        file_put_contents($htmlPath, $htmlContent);

        echo "Generated: $htmlPath\n";
    }
}

generateMirror($phpFiles, $outputDir);

echo "Mirror HTML project generated in: $outputDir\n";

// Install and build Tailwind CSS inside the mirror_html directory
chdir($outputDir);

// Step 1: Initialize npm if needed
if (!file_exists('package.json')) {
    echo "Initializing npm...\n";
    shell_exec('npm init -y');
}

// Step 2: Install Tailwind CSS if not already installed
if (!file_exists('node_modules/tailwindcss')) {
    echo "Installing Tailwind CSS...\n";
    shell_exec('npm install tailwindcss');
}

// Step 3: Create tailwind.config.js if not present
$tailwindConfigPath = $outputDir . '/tailwind.config.js';
if (!file_exists($tailwindConfigPath)) {
    echo "Generating Tailwind CSS config...\n";
    $tailwindConfigContent = <<<CONFIG
module.exports = {
    content: ['./*.html'], // Adjust paths to include all HTML files
    theme: {
        extend: {},
    },
    plugins: [],
};
CONFIG;
    file_put_contents($tailwindConfigPath, $tailwindConfigContent);
}

// Step 4: Generate an input.css file for Tailwind CSS
$cssInputPath = $outputDir . '/input.css';
if (!file_exists($cssInputPath)) {
    file_put_contents($cssInputPath, "@tailwind base;\n@tailwind components;\n@tailwind utilities;");
    echo "Created input.css\n";
}

// Step 5: Build Tailwind CSS to produce output.css
$outputCssPath = $outputDir . '/output.css';
echo "Building Tailwind CSS...\n";
shell_exec("npx tailwindcss -i input.css -o output.css --minify");

if (file_exists($outputCssPath)) {
    echo "Tailwind CSS built successfully: $outputCssPath\n";
} else {
    echo "Failed to build Tailwind CSS.\n";
}

ob_end_flush();
