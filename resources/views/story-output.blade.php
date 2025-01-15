<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Output</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            overflow: hidden; /* Prevent scrollbar visibility */
        }
        .story-content { 
            white-space: pre-wrap; 
            line-height: 1.8; 
            max-height: 70vh; 
            overflow-y: scroll; 
            scrollbar-width: none; /* For Firefox */
        }
        .story-content::-webkit-scrollbar {
            display: none; /* For Chrome, Safari, and Edge */
        }
        .highlight {
            background-color: rgba(59, 130, 246, 0.3);
            border-radius: 4px;
            padding: 2px 4px;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 text-white flex items-center justify-center">

    <!-- Card Container -->
    <div class="w-full max-w-3xl p-8 bg-opacity-80 bg-gray-800 rounded-lg shadow-xl">
        <!-- Title -->
        <div class="text-center mb-6">
            <h4 class="text-5xl font-semibold text-blue-300">
                {{ $bookName }}
            </h4>
        </div>

        <!-- Story Content -->
        <div class="story-content text-lg space-y-6" id="story-content">
            <h5 class="text-3xl font-semibold mb-4">Generated Story:</h5>
            <p class="text-xl leading-relaxed text-gray-300" id="story-text">
                {{ $storyContent }}
            </p>
        </div>

        <!-- Controls -->
        <div class="text-center mt-6 space-x-4">
            <button id="play-tts" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition duration-200 ease-in-out focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-md">
                Play Story
            </button>
            <button id="stop-tts" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-md font-medium transition duration-200 ease-in-out focus:ring-2 focus:ring-red-400 focus:outline-none shadow-md">
                Stop
            </button>
            <a href="/" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-md font-medium transition duration-200 ease-in-out focus:ring-2 focus:ring-gray-400 focus:outline-none shadow-md">
                Generate Another Story
            </a>
        </div>
    </div>

    <!-- JavaScript for TTS, Highlighting, and Scrolling -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const storyTextElement = document.getElementById('story-text');
            const playButton = document.getElementById('play-tts');
            const stopButton = document.getElementById('stop-tts');
            const storyContent = document.getElementById('story-content');
            const synth = window.speechSynthesis;
            let utterance = null;
            let sentences = [];

            // Remove all '*' characters manually
            let sanitizedContent = storyTextElement.textContent;
            storyTextElement.textContent = sanitizedContent.split('*').join('');

            // Split story text into sentences
            function splitIntoSentences(text) {
                return text.split(/(?<=[.?!])\s+/); // Matches sentences ending with punctuation followed by a space
            }

            // Highlight the current sentence
            function highlightSentence(index) {
                storyTextElement.innerHTML = sentences
                    .map((sentence, i) =>
                        i === index ? `<span class="highlight">${sentence}</span>` : sentence
                    )
                    .join(" ");
            }

            // Scroll to the highlighted sentence
            function scrollToHighlight(index) {
                const highlights = document.querySelectorAll(".highlight");
                if (highlights.length > 0 && highlights[index]) {
                    highlights[index].scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });
                }
            }

            // Handle TTS playback
            function playStory() {
                const text = storyTextElement.textContent;
                sentences = splitIntoSentences(text);
                let currentSentence = 0;

                utterance = new SpeechSynthesisUtterance();
                utterance.lang = 'en-US'; // Change language if needed
                utterance.rate = 1; // Adjust speed
                utterance.pitch = 1; // Adjust pitch

                // Set initial sentence and start speaking
                utterance.text = sentences[currentSentence];
                highlightSentence(currentSentence);
                scrollToHighlight(currentSentence);
                synth.speak(utterance);

                // Move to next sentence after speaking each one
                utterance.addEventListener('end', () => {
                    currentSentence++;
                    if (currentSentence < sentences.length) {
                        utterance.text = sentences[currentSentence];
                        highlightSentence(currentSentence);
                        scrollToHighlight(currentSentence);
                        synth.speak(utterance);
                    } else {
                        // Clear highlights when done
                        storyTextElement.innerHTML = sentences.join(" ");
                    }
                });
            }

            // Stop TTS and clear highlights
            function stopStory() {
                if (synth.speaking) {
                    synth.cancel();
                }
                storyTextElement.innerHTML = sentences.join(" ");
            }

            // Attach event listeners
            playButton.addEventListener('click', playStory);
            stopButton.addEventListener('click', stopStory);
        });
    </script>

</body>
</html>
