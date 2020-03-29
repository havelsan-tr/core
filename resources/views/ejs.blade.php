<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/ejs@3.0.1/ejs.min.js" integrity="sha256-UBBPCOEPxc2jDuQMgYvzemO9GqrRd0UkYHVwl78VbqI=" crossorigin="anonymous"></script>
</head>
<script>

    function renderEjs(){
        let people = ['geddy', 'neil', 'alex'],
        html = ejs.render('<%= people.join(", "); %>', {people: people});
        document.getElementById('mainData').innerHTML = html
    }
  </script>
<body>
    <button onclick="renderEjs()">Render</button>
    <pre id="mainData">
        
    </pre>
</body>
</html>