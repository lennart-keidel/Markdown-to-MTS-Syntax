<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown to Custom Syntax Converter</title>
</head>
<body>

<h1>Markdown to Custom Syntax Converter</h1>

<form method="post">
    <legend>Convert</legend>
    <legend for="mode1">From Markdown to Custom Syntax</legend>
    <legend for="mode2">From Custom Syntax to Markdown</legend>
    <input type="radio" name="mode" id="mode1" value="1" checked>
    <input type="radio" name="mode" id="mode2" value="2">
    <textarea name="markdownText" rows="10" cols="50" placeholder="Enter Markdown Text"></textarea><br>
    <input type="submit" value="Convert">
</form>

<?php

function convertMarkdownToCustomSyntax($text) {
    // Replace headings
    $text = preg_replace('/^# (.*)$/m', '[header1]$1[/header1]', $text);
    $text = preg_replace('/^## (.*)$/m', '[b]$1[/b]', $text);
    $text = preg_replace('/^### (.*)$/m', '[b]$1[/b]', $text);
    $text = preg_replace('/^#### (.*)$/m', '[b]$1[/b]', $text);

    // Replace bold text
    $text = preg_replace('/\*\*(.*?)\*\*/', '[b]$1[/b]', $text);

    // Replace links
    $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '[url=$2]$1[/url]', $text);

    // Replace list items
    $text = preg_replace('/^-\s*\[.\]\s*(.*)$/m', '[*] $1', $text);
    $text = preg_replace('/^-\s*(.*)$/m', '[*] $1', $text);

    return $text;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted
    if (isset($_POST["markdownText"])) {
        // Get the input markdown text
        $markdownText = $_POST["markdownText"];

        // Convert markdown to custom syntax
        $customSyntaxText = $_POST["mode"] == "1" ? convertMarkdownToCustomSyntax($markdownText) : convertCustomSyntaxToMarkdown($markdownText);

        // Output converted text
        echo "<h2>Converted Text:</h2>";
        echo "<pre>$customSyntaxText</pre>";
    }
}


function convertCustomSyntaxToMarkdown($text) {
    // Replace headers
    $text = preg_replace('/\[header1\](.*?)\[\/header1\]/', '# $1', $text);
    $text = preg_replace('/\[header2\](.*?)\[\/header2\]/', '## $1', $text);

    // Replace bold text
    $text = preg_replace('/\[b\](.*?)\[\/b\]/', '**$1**', $text);

    // Replace links
    $text = preg_replace('/\[url=(.*?)\](.*?)\[\/url\]/', '[$2]($1)', $text);
    $text = preg_replace('/\[\*\]/', '-', $text);
    $text = preg_replace('/\[list\]/', '', $text);
    $text = preg_replace('/\[\/list\]/', '', $text);

    return $text;
}
?>


</body>
</html>
