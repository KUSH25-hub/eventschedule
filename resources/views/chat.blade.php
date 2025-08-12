<!DOCTYPE html>
<html>
<head>
    <title>Chat with TinyLLaMA</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        textarea { width: 100%; height: 80px; padding: 10px; font-size: 16px; }
        button { padding: 10px 15px; font-size: 16px; margin-top: 10px; }
        .response { background: #f4f4f4; padding: 15px; margin-top: 20px; border-radius: 5px; }
    </style>
</head>
<body>

<h1>💬 Chat with TinyLLaMA</h1>

<form method="POST" action="/chat">
    @csrf
    <label for="prompt">Your Prompt:</label>
    <textarea name="prompt" id="prompt" required>{{ $prompt ?? '' }}</textarea>
    <br>
    <button type="submit">Send</button>
</form>

@if(!empty($response))
    <div class="response">
        <strong>LLM says:</strong>
        <p>{{ $response }}</p>
    </div>
@endif

</body>
</html>
