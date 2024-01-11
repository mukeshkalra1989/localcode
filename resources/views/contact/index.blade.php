<!-- resources/views/upload.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV File Upload</title>
</head>
<body>
    <form action="{{ route('uploadcsv') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="file">Choose CSV File:</label>
        <input type="file" name="file" id="file">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
