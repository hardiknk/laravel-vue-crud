<!DOCTYPE html>
<html>
<head>
    <title>AI Text Generator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">AI Text Generator</h1>
            <p class="text-gray-600">Powered by ChatGPT</p>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Input Section -->
            <div class="mb-6">
                <label for="promptInput" class="block text-gray-700 text-sm font-semibold mb-2">
                    Your Prompt
                </label>
                <textarea 
                    id="promptInput" 
                    rows="4" 
                    class="w-full px-4 py-2 text-gray-700 border rounded-lg focus:outline-none focus:border-blue-500 transition-all resize-none"
                    placeholder="Enter your prompt here..."
                ></textarea>
            </div>

            <!-- Button Section -->
            <div class="flex justify-center mb-6">
                <button 
                    onclick="generateText()"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                >
                    <i class="fas fa-magic"></i>
                    Generate Text
                </button>
            </div>

            <!-- Result Section -->
            <div class="relative">
                <div id="result" class="min-h-[100px] bg-gray-50 rounded-lg p-4 text-gray-700">
                    <!-- Content will be loaded here -->
                </div>

                <!-- Loading Indicator -->
                <div id="loading" class="hidden absolute inset-0 bg-gray-50 bg-opacity-90 rounded-lg flex items-center justify-center">
                    <div class="flex flex-col items-center">
                        <div class="animate-pulse">
                            <i class="fas fa-spinner fa-spin text-blue-600 text-3xl"></i>
                        </div>
                        <p class="mt-2 text-gray-600">Generating your text...</p>
                    </div>
                </div>
            </div>

            <!-- Copy Button (appears when there's content) -->
            <div id="copyContainer" class="hidden mt-4 flex justify-end">
                <button 
                    onclick="copyText()"
                    class="text-gray-600 hover:text-gray-800 font-medium py-2 px-4 rounded-lg transition-all flex items-center gap-2"
                >
                    <i class="fas fa-copy"></i>
                    Copy to Clipboard
                </button>
            </div>
        </div>
    </div>

    <script>
        function generateText() {
            const prompt = $('#promptInput').val();
            
            if (!prompt.trim()) {
                $('#result').html('<p class="text-red-500">Please enter a prompt first!</p>');
                return;
            }

            $('#loading').removeClass('hidden');
            $('#copyContainer').addClass('hidden');
            
            $.ajax({
                url: '/generate-text',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    prompt: prompt
                },
                success: function(response) {
                    $('#loading').addClass('hidden');
                    if (response.success) {
                        $('#result').html(response.data);
                        $('#copyContainer').removeClass('hidden');
                    } else {
                        $('#result').html('<p class="text-red-500">Error: ' + response.message + '</p>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#loading').addClass('hidden');
                    $('#result').html('<p class="text-red-500">Error: ' + error + '</p>');
                }
            });
        }

        function copyText() {
            const text = $('#result').text();
            navigator.clipboard.writeText(text).then(() => {
                const button = $('#copyContainer button');
                button.html('<i class="fas fa-check"></i> Copied!');
                button.addClass('text-green-600');
                setTimeout(() => {
                    button.html('<i class="fas fa-copy"></i> Copy to Clipboard');
                    button.removeClass('text-green-600');
                }, 2000);
            });
        }
    </script>
</body>
</html>