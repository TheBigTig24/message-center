<!DOCTYPE html>
<head>
    <title>Test</title>
    <script>
        async function test() {
            const response = await fetch('http://localhost:3001/routes/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const data = await response.json();

            if (data.status === 'success') {
                console.log('Success:', data);
            } else {
                console.error('Error:', data);
            }
        }
    </script>
</head>
<body>
    <button onclick="test()">1</button>
</body>
